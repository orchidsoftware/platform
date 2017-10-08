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
        $dashboard->permission->registerPermissions($this->registerPermissionsPages());
        $dashboard->permission->registerPermissions($this->registerPermissionsPost());
        $dashboard->permission->registerPermissions($this->registerPermissionsSystems());
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
                    'slug'        => 'dashboard.pages',
                    'description' => trans('dashboard::permission.main.pages'),
                ],
                [
                    'slug'        => 'dashboard.posts',
                    'description' => trans('dashboard::permission.main.posts'),
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
                    'slug'        => 'dashboard.systems.menu',
                    'description' => trans('dashboard::permission.systems.menu'),
                ],
                [
                    'slug'        => 'dashboard.systems.category',
                    'description' => trans('dashboard::permission.systems.category'),
                ],
                [
                    'slug'        => 'dashboard.systems.comment',
                    'description' => trans('dashboard::permission.systems.comment'),
                ],
                [
                    'slug'        => 'dashboard.systems.attachment',
                    'description' => trans('dashboard::permission.systems.attachment'),
                ],
                [
                    'slug'        => 'dashboard.systems.media',
                    'description' => trans('dashboard::permission.systems.media'),
                ],

            ],
        ];
    }

}
