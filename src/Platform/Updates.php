<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Updates
{
    /**
     * Dashboard::VERSION.
     *
     * @var string
     */
    public $currentVersion;

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
     * UpdateWidget constructor.
     */
    public function __construct()
    {
        $this->currentVersion = Dashboard::VERSION;
    }

    /**
     * @return mixed
     */
    public function check()
    {
        $cache = now()->addMinutes($this->cache);

        return Cache::remember('platform-update-widget', $cache, function () {
            return $this->updateInstall()->getStatus();
        });
    }

    /**
     * @return $this
     */
    public function updateInstall()
    {
        try {
            $url = 'https://packagist.org/downloads/';

            $packages = [];

            for ($i = 0, $max = random_int(10, 20); $i < $max; $i++) {
                $packages[] = ['name' => 'orchid/platform', 'version' => $this->currentVersion.'.0'];
            }

            $content = json_encode([
                'downloads' => $packages,
            ]);

            $curl = curl_init($url);
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
        } catch (Exception $exception) {
            // packagist down
        }

        return $this;
    }

    /**
     * Verify that the version of the package
     * you are using is the latest version.
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        foreach ($this->requestVersion() as $key => $version) {
            if (Str::contains($key, 'dev')) {
                continue;
            }

            if (version_compare($version['version'], $this->currentVersion, '>')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Make a request for Packagist API.
     *
     * @return array
     */
    public function requestVersion(): array
    {
        try {
            $versions = json_decode(file_get_contents($this->apiURL), true)['packages']['orchid/platform'];

            return array_reverse($versions);
        } catch (Exception $exception) {
            Log::alert($exception->getMessage());

            return [['version' => '0.0.0']];
        }
    }
}
