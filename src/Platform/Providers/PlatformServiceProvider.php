<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Http\Composers\SystemMenuComposer;
use Orchid\Platform\Http\Composers\AnnouncementsComposer;
use Orchid\Platform\Http\Composers\NotificationsComposer;

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
            ->addPublicDirectory('orchid',PLATFORM_PATH.'/public/');
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain(): array
    {
        return [
            __('Main') => [
                [
                    'slug'        => 'platform.index',
                    'description' => __('Main'),
                ],
                [
                    'slug'        => 'platform.systems',
                    'description' => __('Systems'),
                ],
                [
                    'slug'        => 'platform.systems.index',
                    'description' => __('Settings'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsSystems(): array
    {
        return [
            __('Systems') => [
                [
                    'slug'        => 'platform.systems.attachment',
                    'description' => __('Attachment'),
                ],
                [
                    'slug'        => 'platform.systems.cache',
                    'description' => __('Cache'),
                ],
                [
                    'slug'        => 'platform.systems.backups',
                    'description' => __('Backups'),
                ],
                [
                    'slug'        => 'platform.systems.announcement',
                    'description' => __('Announcement'),
                ],
            ],
        ];
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
