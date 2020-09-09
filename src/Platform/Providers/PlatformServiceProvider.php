<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use App\Orchid\PlatformProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Icons\IconFinder;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Http\Composers\LockMeComposer;
use Orchid\Platform\Http\Composers\NotificationsComposer;
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

        View::composer('platform::auth.login', LockMeComposer::class);
        View::composer('platform::partials.notificationProfile', NotificationsComposer::class);

        $icons = array_merge(['o' => $dashboard::path('public/icons')], config('orchid.icons', []));

        foreach ($icons as $key => $path) {
            $iconFinder->registerIconDirectory($key, $path);
        }

        $this->app->booted(function () {
            $this->dashboard
                ->registerResource('stylesheets', config('platform.resource.stylesheets', null))
                ->registerResource('scripts', config('platform.resource.scripts', null))
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
            ->addPermission('platform.index', __('Main'))
            ->addPermission('platform.systems.index', __('Systems'));
    }

    /**
     * @return ItemPermission
     */
    protected function registerPermissionsSystems(): ItemPermission
    {
        return ItemPermission::group(__('Systems'))
            ->addPermission('platform.systems.attachment', __('Attachment'));
    }

    /**
     * Register provider.
     */
    public function register()
    {
        if (class_exists(PlatformProvider::class)) {
            $this->app->register(PlatformProvider::class);
        }
    }
}
