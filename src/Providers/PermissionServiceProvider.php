<?php

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Kernel\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var
     */
    protected $dashboard;

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        $dashboard->permission->registerPermissions($this->registerPermissionsMain());
        $dashboard->permission->registerPermissions($this->registerPermissionsSystems());

        $dashboard->permission->registerPermissions($this->registerPermissionsMain());
        $dashboard->permission->registerPermissions($this->registerPermissionsPages());
        $dashboard->permission->registerPermissions($this->registerPermissionsPost());
        $dashboard->permission->registerPermissions($this->registerPermissionsTools());
        $dashboard->permission->registerPermissions($this->registerPermissionsSystems());
        $dashboard->permission->registerPermissions($this->registerPermissionsMarketing());
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


    /**
     * @return array
     */
    protected function registerPermissionsMain() : array
    {
        return [
            'Main' => [
                [
                    'slug'        => 'dashboard.index',
                    'description' => trans('dashboard::permission.main.main'),
                ],
                [
                    'slug'        => 'dashboard.systems',
                    'description' => trans('dashboard::permission.main.systems'),
                ],
                [
                    'slug'        => 'dashboard.index',
                    'description' => trans('dashboard::permission.main.main'),
                ],
                [
                    'slug'        => 'dashboard.pages',
                    'description' => trans('dashboard::permission.main.pages'),
                ],
                [
                    'slug'        => 'dashboard.posts',
                    'description' => trans('dashboard::permission.main.posts'),
                ],
                [
                    'slug'        => 'dashboard.tools',
                    'description' => trans('dashboard::permission.main.tools'),
                ],
                [
                    'slug'        => 'dashboard.marketing',
                    'description' => trans('dashboard::permission.main.marketing'),
                ],
            ],

        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsPages() : array
    {
        $allPage = $this->dashboard->getStorage('pages')->all();

        $showPost = collect();
        foreach ($allPage as $page) {
            $showPost->push([
                'slug'        => 'dashboard.posts.type.' . $page->slug,
                'description' => $page->name,
            ]);
        }

        return [
            'Pages' => $showPost->toArray(),
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsPost() : array
    {
        $allPost = $this->dashboard->getStorage('posts')->all();

        $showPost = collect();
        foreach ($allPost as $page) {
            if ($page->display) {
                $showPost->push([
                    'slug'        => 'dashboard.posts.type.' . $page->slug,
                    'description' => $page->name,
                ]);
            }
        }

        return [
            'Posts' => $showPost->toArray(),
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsTools() : array
    {
        return [
            'Tools' => [
                [
                    'slug'        => 'dashboard.systems.menu',
                    'description' => trans('dashboard::permission.tools.menu'),
                ],
                [
                    'slug'        => 'dashboard.systems.category',
                    'description' => trans('dashboard::permission.tools.category'),
                ],
                [
                    'slug'        => 'dashboard.systems.comment',
                    'description' => trans('dashboard::permission.tools.comment'),
                ],
                [
                    'slug'        => 'dashboard.systems.attachment',
                    'description' => trans('dashboard::permission.tools.attachment'),
                ],
                [
                    'slug'        => 'dashboard.systems.media',
                    'description' => trans('dashboard::permission.tools.media'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsSystems() : array
    {
        return [
            'Systems' => [
                [
                    'slug'        => 'dashboard.systems.roles',
                    'description' => trans('dashboard::permission.systems.roles'),
                ],
                [
                    'slug'        => 'dashboard.systems.settings',
                    'description' => trans('dashboard::permission.systems.settings'),
                ],
                [
                    'slug'        => 'dashboard.systems.users',
                    'description' => trans('dashboard::permission.systems.users'),
                ],
                [
                    'slug'        => 'superuser',
                    'description' => trans('dashboard::permission.systems.superuser'),
                ],
                [
                    'slug'        => 'dashboard.systems.backup',
                    'description' => trans('dashboard::permission.systems.backup'),
                ],
                [
                    'slug'        => 'dashboard.systems.defender',
                    'description' => trans('dashboard::permission.systems.defender'),
                ],
                [
                    'slug'        => 'dashboard.systems.monitor',
                    'description' => trans('dashboard::permission.systems.monitor'),
                ],
                [
                    'slug'        => 'dashboard.systems.logs',
                    'description' => trans('dashboard::permission.systems.logs'),
                ],
                [
                    'slug'        => 'dashboard.systems.schema',
                    'description' => trans('dashboard::permission.systems.schema'),
                ],
                [
                    'slug'        => 'dashboard.systems.settings',
                    'description' => trans('dashboard::permission.systems.settings'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsMarketing() : array
    {
        return [

            'Marketing' => [
                [
                    'slug'        => 'dashboard.marketing.utm',
                    'description' => trans('dashboard::permission.marketing.utm'),
                ],
                [
                    'slug'        => 'dashboard.marketing.robots',
                    'description' => trans('dashboard::permission.marketing.robots'),
                ],
            ],

        ];
    }




}
