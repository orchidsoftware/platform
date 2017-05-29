<?php

namespace Orchid\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Kernel\Dashboard;

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
        $dashboard->permission->registerPermissions($this->registerPermissionsPages());
        $dashboard->permission->registerPermissions($this->registerPermissionsPost());
        $dashboard->permission->registerPermissions($this->registerPermissionsTools());
        $dashboard->permission->registerPermissions($this->registerPermissionsSystems());
        $dashboard->permission->registerPermissions($this->registerPermissionsMarketing());
    }

    /**
     * @return array
     */
    protected function registerPermissionsMain(): array
    {
        return [
            'Main' => [
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
                    'slug'        => 'dashboard.systems',
                    'description' => trans('dashboard::permission.main.systems'),
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
    protected function registerPermissionsPages(): array
    {
        $allPage = $this->dashboard->pages();

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
    protected function registerPermissionsPost(): array
    {
        $allPost = $this->dashboard->posts();
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
    protected function registerPermissionsTools(): array
    {
        return [
            'Tools' => [
                [
                    'slug'        => 'dashboard.tools.menu',
                    'description' => trans('dashboard::permission.tools.menu'),
                ],
                [
                    'slug'        => 'dashboard.tools.category',
                    'description' => trans('dashboard::permission.tools.category'),
                ],
                [
                    'slug'        => 'dashboard.tools.attachment',
                    'description' => trans('dashboard::permission.tools.attachment'),
                ],
                [
                    'slug'        => 'dashboard.tools.media',
                    'description' => trans('dashboard::permission.tools.media'),
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

            'Systems' => [
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
                    'slug'        => 'dashboard.systems.roles',
                    'description' => trans('dashboard::permission.systems.roles'),
                ],
                [
                    'slug'        => 'dashboard.systems.schema',
                    'description' => trans('dashboard::permission.systems.schema'),
                ],
                [
                    'slug'        => 'dashboard.systems.settings',
                    'description' => trans('dashboard::permission.systems.settings'),
                ],
                [
                    'slug'        => 'dashboard.systems.users',
                    'description' => trans('dashboard::permission.systems.users'),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function registerPermissionsMarketing(): array
    {
        return [

            'Marketing' => [
                [
                    'slug'        => 'dashboard.marketing.comment',
                    'description' => trans('dashboard::permission.marketing.comment'),
                ],
                [
                    'slug'        => 'dashboard.marketing.advertising',
                    'description' => trans('dashboard::permission.marketing.advertising'),
                ],
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
