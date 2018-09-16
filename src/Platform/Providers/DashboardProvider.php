<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Http\Composers\SystemMenuComposer;
use Orchid\Platform\Http\Composers\AnnouncementsComposer;
use Orchid\Platform\Http\Composers\NotificationsComposer;

class DashboardProvider extends ServiceProvider
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
    public function boot(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        View::composer('platform::container.systems.index', SystemMenuComposer::class);
        View::composer('platform::partials.notifications', NotificationsComposer::class);
        View::composer('platform::partials.announcement', AnnouncementsComposer::class);

        $this->dashboard
            ->registerResource(config('platform.resource', []))
            ->registerPermissions($this->registerPermissionsMain())
            ->registerPermissions($this->registerPermissionsSystems());
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain(): array
    {
        return [
            trans('platform::permission.main.main') => [
                [
                    'slug'        => 'platform.index',
                    'description' => trans('platform::permission.main.main'),
                ],
                [
                    'slug'        => 'platform.systems',
                    'description' => trans('platform::permission.main.systems'),
                ],
                [
                    'slug'        => 'platform.systems.index',
                    'description' => trans('platform::permission.systems.settings'),
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
            trans('platform::permission.main.systems') => [
                [
                    'slug'        => 'platform.systems.attachment',
                    'description' => trans('platform::permission.systems.attachment'),
                ],
                [
                    'slug'        => 'platform.systems.media',
                    'description' => trans('platform::permission.systems.media'),
                ],
                [
                    'slug'        => 'platform.systems.cache',
                    'description' => trans('platform::permission.systems.cache'),
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
