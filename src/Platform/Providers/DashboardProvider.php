<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Support\Facades\View;
use Orchid\Platform\Http\Composers\MenuComposer;
use Orchid\Platform\Kernel\Dashboard;
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
        View::composer('dashboard::layouts.dashboard', MenuComposer::class);
        
        $this->dashboard = $dashboard;
        
        $this->dashboard
            ->registerFields(config('platform.fields'))
            ->registerManyBehavior(config('platform.many'))
            ->registerSingleBehavior(config('platform.single'))
            ->registerResource(config('platform.resource', []))
            ->registerPermissions($this->registerPermissionsMain())
            ->registerPermissions($this->registerPermissionsBehaviors())
            ->registerPermissions($this->registerPermissionsSystems());
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
    protected function registerPermissionsBehaviors() : array
    {
        $pages = $this->dashboard->getSingleBehaviors()->map(function ($page) {
            return [
                'slug'          => 'dashboard.pages.type.'.$page->slug,
                'description'   => $page->name,
            ];
        });
        
        $posts = $this->dashboard->getManyBehaviors()->map(function ($post) {
            return [
                'slug'          => 'dashboard.posts.type.'.$post->slug,
                'description'   => $post->name,
            ];
        });
        
        return [
            'Pages' => $pages,
            'Posts' => $posts,
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
