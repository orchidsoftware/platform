<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Icons\IconFinder;
use Orchid\Platform\Orchid;
use Orchid\Platform\ItemPermission;

class PlatformServiceProvider extends ServiceProvider
{
    /**
     * @var Orchid
     */
    protected $dashboard;

    /**
     * Boot the application events.
     */
    public function boot(Orchid $dashboard, IconFinder $iconFinder): void
    {
        $this->dashboard = $dashboard;

        foreach (config('orchid.icons', []) as $key => $path) {
            $iconFinder->registerIconDirectory($key, $path);
        }

        $this->app->booted(function () {
            $this->dashboard
                ->registerResource('stylesheets', config('orchid.resource.stylesheets'))
                ->registerResource('scripts', config('orchid.resource.scripts'))
                ->registerSearch(config('orchid.search', []))
                ->registerPermissions($this->registerPermissionsMain())
                ->registerPermissions($this->registerPermissionsSystems());
        });
    }

    protected function registerPermissionsMain(): ItemPermission
    {
        return ItemPermission::group(__('Main'))
            ->addPermission('orchid.index', __('Main'));
    }

    protected function registerPermissionsSystems(): ItemPermission
    {
        return ItemPermission::group(__('System'))
            ->addPermission('orchid.systems.attachment', __('Attachment'));
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $provider = config('orchid.provider', \App\Orchid\PlatformProvider::class);

        if ($provider !== null && class_exists($provider)) {
            $this->app->register($provider);
        }
    }
}
