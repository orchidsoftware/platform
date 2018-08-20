<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Widgets;

use Orchid\Widget\Widget;
use Orchid\Platform\Dashboard;
use Composer\Semver\Comparator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UpdateWidget extends Widget
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
    public function handler()
    {
        $status = Cache::remember('platform-update-widget', $this->cache, function () {
            return $this->getStatus();
        });

        return view('platform::widgets.update', [
            'status' => $status,
        ]);
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
            if ($key !== 'dev-master' && Comparator::greaterThan($version['version'],
                    $this->currentVersion)) {
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
            return json_decode(file_get_contents($this->apiURL), true)['packages']['orchid/platform'];
        } catch (\Exception $exception) {
            Log::alert($exception->getMessage());

            return ['0.0.0'];
        }
    }
}
