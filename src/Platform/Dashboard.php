<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;

class Dashboard
{
    use Configuration\ManagesMenu,
        Configuration\ManagesModelOptions,
        Configuration\ManagesPackage,
        Configuration\ManagesPermissions,
        Configuration\ManagesResources,
        Configuration\ManagesScreens,
        Configuration\ManagesSearch,
        Macroable;

    /**
     * The current Orchid version.
     *
     * @deprecated Use `Dashboard::version()` instead.
     */
    public const VERSION = '14.52.0';

    /**
     * @deprecated
     *
     * Slug for main menu.
     */
    public const MENU_MAIN = 'Main';

    /**
     * The Dashboard configuration options.
     *
     * @var array
     */
    protected static $options = [
        'search' => [],
        'models' => [],
    ];

    /**
     * Dashboard constructor.
     */
    public function __construct()
    {
        $this->resources = collect();

        $this->permission = collect([
            'all'     => collect(),
            'removed' => collect(),
        ]);

        $this->flushState();
    }

    /**
     * Get the route with the dashboard prefix.
     */
    public static function prefix(string $path = ''): string
    {
        $prefix = config('platform.prefix');

        return Str::start($prefix.$path, '/');
    }

    /**
     * Configure the Dashboard application.
     */
    public static function configure(array $options): void
    {
        static::$options = $options;
    }

    /**
     * Get a Dashboard configuration option.
     *
     * @param mixed|null $default
     *
     * @return mixed
     */
    public static function option(string $key, $default = null)
    {
        return Arr::get(static::$options, $key, $default);
    }

    /**
     * Clear all persistent state information in the Orchid.
     *
     * This method is essential for Laravel Octane to properly handle stateful requests
     * when the Dashboard is used as a singleton. It ensures that any stored data
     * and state information are reset, avoiding potential issues with stale or
     * inconsistent data between requests.
     */
    public function flushState(): void
    {
        $this->menu = collect();

        $this->currentScreen = null;
        $this->partialRequest = false;
    }
}
