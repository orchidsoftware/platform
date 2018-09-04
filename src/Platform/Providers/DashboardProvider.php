<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        View::composer('platform::container.systems.index', $this->registerMenu());

        $this->dashboard
            ->registerResource(config('platform.resource', []))
            ->registerPermissions($this->registerPermissionsMain())
            ->registerPermissions($this->registerPermissionsSystems());
    }

    protected function registerMenu()
    {
        $this->dashboard->menu
            ->add('Systems', [
                'slug'       => 'Cache',
                'icon'       => 'icon-refresh',
                'label'      => trans('platform::systems/settings.system_menu.Cache configuration'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 2000,
            ])
            ->add('Cache', [
                'slug'       => 'cache:clear',
                'icon'       => 'icon-refresh',
                'route'      => route('platform.systems.cache', ['action' => 'cache']),
                'label'      => trans('platform::systems/cache.cache'),
                'groupname'  => trans('platform::systems/cache.cache.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'config:cache',
                'icon'       => 'icon-wrench',
                'route'      => route('platform.systems.cache', ['action' => 'config']),
                'label'      => trans('platform::systems/cache.config'),
                'groupname'  => trans('platform::systems/cache.config.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'route:cache',
                'icon'       => 'icon-directions',
                'route'      => route('platform.systems.cache', ['action' => 'route']),
                'label'      => trans('platform::systems/cache.route'),
                'groupname'  => trans('platform::systems/cache.route.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'view:clear',
                'icon'       => 'icon-monitor',
                'route'      => route('platform.systems.cache', ['action' => 'view']),
                'label'      => trans('platform::systems/cache.view'),
                'groupname'  => trans('platform::systems/cache.view.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'opcache:clear',
                'icon'       => 'icon-settings',
                'route'      => route('platform.systems.cache', ['action' => 'opcache']),
                'label'      => trans('platform::systems/cache.opcache'),
                'groupname'  => trans('platform::systems/cache.opcache.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
                'show'       => function_exists('opcache_reset'),
            ]);
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
                    'slug'        => 'platform.systems.roles',
                    'description' => trans('platform::permission.systems.roles'),
                ],
                [
                    'slug'        => 'platform.systems.users',
                    'description' => trans('platform::permission.systems.users'),
                ],
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
