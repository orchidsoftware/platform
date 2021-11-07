<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\IconPack\Path;
use Orchid\Icons\IconFinder;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;

class PlatformServiceProvider extends ServiceProvider
{
    /**
     * @var Dashboard
     */
    protected $dashboard;

    /**
     * Boot the application events.
     *
     * @param Dashboard  $dashboard
     * @param IconFinder $iconFinder
     */
    public function boot(Dashboard $dashboard, IconFinder $iconFinder): void
    {
        $this->dashboard = $dashboard;

        $icons = array_merge(['o' => Path::getFolder()], config('platform.icons', []));

        foreach ($icons as $key => $path) {
            $iconFinder->registerIconDirectory($key, $path);
        }

        $this->app->booted(function () {
            $this->dashboard
                ->registerResource('stylesheets', config('platform.resource.stylesheets'))
                ->registerResource('scripts', config('platform.resource.scripts'))
                ->registerSearch(config('platform.search', []))
                ->registerPermissions($this->registerPermissionsMain())
                ->registerPermissions($this->registerPermissionsSystems())
                ->addPublicDirectory('orchid', Dashboard::path('public/'));
        });
    }

    /**
     * @return ItemPermission
     */
    protected function registerPermissionsMain(): ItemPermission
    {
        return ItemPermission::group(__('Main'))
            ->addPermission('platform.index', __('Main'));
    }

    /**
     * @return ItemPermission
     */
    protected function registerPermissionsSystems(): ItemPermission
    {
        return ItemPermission::group(__('System'))
            ->addPermission('platform.systems.attachment', __('Attachment'));
    }

    /**
     * Register provider.
     */
    public function register()
    {
        $provider = config('platform.provider', \App\Orchid\PlatformProvider::class);

        if ($provider !== null && class_exists($provider)) {
            $this->app->register($provider);
        }
    }
}
