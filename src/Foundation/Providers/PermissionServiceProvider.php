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
            'Modules - название модуля' => [
                [
                    'slug'        => 'dashboard.post',
                    'description' => 'Доступ к постам',
                ],
                [
                    'slug'        => 'dashboard.post.images',
                    'description' => 'Доступ к изображениям',
                ],
                [
                    'slug'        => 'dashboard.post.seo',
                    'description' => 'Доступ к SEO параметрам',
                ],
                //etc
            ],

        ];
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
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
