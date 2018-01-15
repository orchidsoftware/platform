<?php

namespace Orchid\Platform\Http\Composers;

use Orchid\Platform\Kernel\Dashboard;

class MenuComposer
{
    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Registering the main menu items.
     */
    public function compose()
    {
        $this->registerMenuSystems($this->dashboard);
        $this->registerMenuPost($this->dashboard);
        $this->registerMenuPage($this->dashboard);
    }

    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuSystems(Dashboard $dashboard)
    {
        $dashboard->menu->add('Main', [
            'slug'       => 'Systems',
            'icon'       => 'icon-layers',
            'route'      => '#',
            'label'      => trans('dashboard::menu.systems'),
            'childs'     => true,
            'main'       => true,
            'active'     => 'dashboard.systems.*',
            'permission' => 'dashboard.systems',
            'sort'       => 1000,
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'settings',
            'icon'       => 'icon-settings',
            'route'      => route('dashboard.systems.settings'),
            'label'      => trans('dashboard::menu.constants'),
            'groupname'  => trans('dashboard::menu.general settings'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.settings',
            'sort'       => 1,
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'menu',
            'icon'       => 'icon-menu',
            'route'      => route('dashboard.systems.menu.index'),
            'label'      => trans('dashboard::menu.menu'),
            'groupname'  => trans('dashboard::menu.posts Managements'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.menu',
            'sort'       => 2,
            'show'       => count(config('platform.menu', [])) > 0,
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'section',
            'icon'       => 'icon-briefcase',
            'route'      => route('dashboard.systems.category'),
            'label'      => trans('dashboard::menu.sections'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.category',
            'sort'       => 3,
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'comment',
            'icon'       => 'fa fa-comments-o',
            'route'      => route('dashboard.systems.comment'),
            'label'      => trans('dashboard::menu.comments'),
            'permission' => 'dashboard.systems.comment',
            'sort'       => 4,
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'media',
            'icon'       => 'icon-folder-alt',
            'route'      => route('dashboard.systems.media.index'),
            'label'      => trans('dashboard::menu.media'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.media',
            'sort'       => 5,
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'users',
            'icon'       => 'icon-user',
            'route'      => route('dashboard.systems.users'),
            'label'      => trans('dashboard::menu.users'),
            'groupname'  => trans('dashboard::menu.users'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.users',
            'sort'       => 9,
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'roles',
            'icon'       => 'fa fa-lock',
            'route'      => route('dashboard.systems.roles'),
            'label'      => trans('dashboard::menu.roles'),
            'childs'     => false,
            'divider'    => true,
            'permission' => 'dashboard.systems.roles',
            'sort'       => 10,
        ]);
    }

    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuPost(Dashboard $dashboard)
    {
        $allPost = $this->dashboard->getStorage('posts')->all();

        if (count($allPost) > 0) {
            $postMenu = [
                'slug'       => 'Posts',
                'icon'       => 'icon-notebook',
                'route'      => '#',
                'label'      => trans('dashboard::menu.posts'),
                'childs'     => true,
                'main'       => true,
                'active'     => 'dashboard.posts.*',
                'permission' => 'dashboard.posts',
                'sort'       => 100,
            ];

            $dashboard->menu->add('Main', $postMenu);
        }
        foreach ($allPost as $key => $page) {
            if ($page->display) {
                $postObject = [
                    'slug'       => $page->slug,
                    'icon'       => $page->icon,
                    'route'      => route('dashboard.posts.type', [$page->slug]),
                    'label'      => $page->name,
                    'childs'     => false,
                    'permission' => 'dashboard.posts.type.'.$page->slug,
                    'sort'       => $key,
                    'groupname'  => $page->groupname,
                    'divider'    => $page->divider,
                ];

                if (reset($allPost) == $page) {
                    $postObject['groupname'] = trans('dashboard::menu.common posts');
                } elseif (end($allPost) == $page) {
                    $postObject['divider'] = true;
                }

                $dashboard->menu->add('Posts', $postObject);
            }
        }
    }

    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuPage(Dashboard $dashboard)
    {
        $allPage = $this->dashboard->getStorage('pages')->all();

        if (count($allPage) > 0) {
            $dashboard->menu->add('Main', [
                'slug'       => 'Pages',
                'icon'       => 'icon-docs',
                'route'      => '#',
                'label'      => trans('dashboard::menu.pages'),
                'childs'     => true,
                'main'       => true,
                'active'     => 'dashboard.pages.*',
                'permission' => 'dashboard.pages',
                'sort'       => 150,
            ]);
        }
        foreach ($allPage as $key => $page) {
            $postObject = [
                'slug'       => $page->slug,
                'icon'       => $page->icon,
                'route'      => route('dashboard.pages.show', [$page->slug]),
                'label'      => $page->name,
                'childs'     => false,
                'permission' => 'dashboard.pages.type.'.$page->slug,
                'sort'       => $key,
                'groupname'  => $page->groupname,
                'divider'    => $page->divider,
            ];

            if (reset($allPage) == $page) {
                $postObject['groupname'] = trans('dashboard::menu.static pages');
            } elseif (end($allPage) == $page) {
                $postObject['divider'] = true;
            }

            $dashboard->menu->add('Pages', $postObject);
        }
    }
}
