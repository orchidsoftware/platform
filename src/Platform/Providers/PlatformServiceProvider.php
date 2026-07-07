<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use App\Orchid\PlatformProvider;
use Illuminate\Support\ServiceProvider;
use Orchid\Access\PermissionGroup;
use Orchid\Icons\IconFinder;
use Orchid\Platform\Orchid;

class PlatformServiceProvider extends ServiceProvider
{
    /**
     * @var Orchid
     */
    protected Orchid $orchid;

    /**
     * Boot the application events.
     */
    public function boot(Orchid $orchid, IconFinder $iconFinder): void
    {
        $this->orchid = $orchid;

        foreach (config('orchid.icons', []) as $key => $path) {
            $iconFinder->registerIconDirectory($key, $path);
        }

        $this->app->booted(function () {
            $this->orchid
                ->registerResource('stylesheets', config('orchid.resource.stylesheets'))
                ->registerResource('scripts', config('orchid.resource.scripts'))
                ->registerSearch(config('orchid.search', []))
                ->registerPermissions($this->registerPermissionsMain())
                ->registerPermissions($this->registerPermissionsSystems());
        });
    }

    protected function registerPermissionsMain(): PermissionGroup
    {
        return PermissionGroup::group(__('Main'))
            ->permission('orchid.index', __('Main'));
    }

    protected function registerPermissionsSystems(): PermissionGroup
    {
        return PermissionGroup::group(__('System'))
            ->permission('orchid.attachment', __('Attachment'));
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $provider = config('orchid.provider', PlatformProvider::class);

        if ($provider !== null && class_exists($provider)) {
            $this->app->register($provider);
        }
    }
}
