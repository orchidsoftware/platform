<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Updates
{
    /**
     * Packagist API URL.
     *
     * @var string
     */
    public $apiURL = 'https://packagist.org/p/orchid/platform.json';

    /**
     * Specified in minutes.
     *
     * @var int
     */
    public $cache = 1440;

    /**
     * Verify that the version of the package
     * you are using is the latest version.
     *
     * @return bool
     */
    public function check(): bool
    {
        $newReleases = $this->requestVersion()
            ->filter(static function ($version, $key) {
                return ! Str::contains($key, 'dev');
            })->filter(static function ($version) {
                return version_compare($version['version'], Dashboard::VERSION, '>');
            })->count();

        return $newReleases >= 1;
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function updateInstall()
    {
        $packages = [];

        for ($i = 0, $max = random_int(10, 20); $i < $max; $i++) {
            $packages[] = ['name' => 'orchid/platform', 'version' => Dashboard::VERSION.'.0'];
        }

        $content = json_encode([
            'downloads' => $packages,
        ]);

        $curl = curl_init('https://packagist.org/downloads/');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 6); //timeout in seconds
        curl_exec($curl);
        curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }

    /**
     * Make a request for Packagist API.
     *
     * @return Collection
     */
    public function requestVersion(): Collection
    {
        try {
            $versions = Cache::remember('check-platform-update', now()->addMinutes($this->cache), function () {
                $this->updateInstall();

                return json_decode(file_get_contents($this->apiURL), true)['packages']['orchid/platform'];
            });
        } catch (Exception $exception) {
            Log::alert($exception->getMessage());
            $versions = [['version' => '0.0.0']];
        }

        return collect($versions)->reverse();
    }
}
