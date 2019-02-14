<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Http\Composers\SystemMenuComposer;
use Orchid\Platform\Http\Composers\AnnouncementsComposer;
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

        View::composer('platform::container.systems.index', SystemMenuComposer::class);
        View::composer('platform::partials.notifications', NotificationsComposer::class);
        View::composer('platform::partials.announcement', AnnouncementsComposer::class);

        $this->dashboard
            ->registerResource('stylesheets', config('platform.resource.stylesheets', null))
            ->registerResource('scripts', config('platform.resource.scripts', null))
            ->registerPermissions($this->registerPermissionsMain())
            ->registerPermissions($this->registerPermissionsSystems())
            ->addPublicDirectory('orchid', PLATFORM_PATH.'/public/');
    }

    /**
     * @return ItemPermission
     */
    protected function registerPermissionsMain(): ItemPermission
    {
        return ItemPermission::setGroup(__('Main'))
            ->addPermission('platform.index',__('Main'))
            ->addPermission('platform.systems',__('Systems'))
            ->addPermission('platform.systems.index',__('Settings'));
    }

    /**
     * @return array
     */
    protected function registerPermissionsSystems(): ItemPermission
    {
        return ItemPermission::setGroup(__('Systems'))
            ->addPermission('platform.systems.attachment',__('Attachment'))
            ->addPermission('platform.systems.cache',__('Cache'))
            ->addPermission('platform.systems.announcement',__('Announcement'));
    }

    /**
     * Register provider.
     */
    public function register()
    {
        if (class_exists(\App\Orchid\PlatformProvider::class)) {
            $this->app->register(\App\Orchid\PlatformProvider::class);
        }
    }
}
