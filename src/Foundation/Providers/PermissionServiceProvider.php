<?php

namespace Orchid\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Foundation\Kernel\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $permissionService = $this->registerPermissions();
        $dashboard->permission->registerPermissions($permissionService);
    }

    protected function registerPermissions()
    {
        return [
            'Главное меню' => [
                [
                    'slug'        => 'dashboard.index',
                    'description' => 'Главное меню',
                ],
                [
                    'slug'        => 'dashboard.posts',
                    'description' => 'Доступ к постам',
                ],
                [
                    'slug'        => 'dashboard.tools',
                    'description' => 'Доступ к инструментам',
                ],
                [
                    'slug'        => 'dashboard.systems',
                    'description' => 'Доступ к параметрам системы',
                ],
            ],

        ];
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
