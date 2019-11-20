<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use App\Orchid\PlatformProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
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
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        $this->dashboard = $dashboard;

        View::composer('platform::auth.login', LockMeComposer::class);
        View::composer('platform::partials.notificationProfile', NotificationsComposer::class);

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
            ->addPermission('platform.systems', __('Systems'))
            ->addPermission('platform.systems.index', __('Settings'));
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
