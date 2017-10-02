<?php

namespace Orchid\Platform\Http\Composers;

use Orchid\Platform\Kernel\Dashboard;

class MenuComposer2
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
     * Registering the main menu items
     */
    public function compose()
    {
        $this->registerMenuPost($this->dashboard);
        $this->registerMenuPage($this->dashboard);
        $this->registerMenuSystems($this->dashboard);
        $this->registerMenuTrash($this->dashboard);
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
                    'permission' => 'dashboard.posts.type.' . $page->slug,
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
                'icon'       => 'fa fa-file-o',
                'route'      => '#',
                'label'      => trans('dashboard::menu.pages'),
                'childs'     => true,
                'main'       => true,
                'active'     => 'dashboard.pages.*',
                'permission' => 'dashboard.pages',
                'sort'       => 50,
            ]);
        }
        foreach ($allPage as $key => $page) {
            $postObject = [
                'slug'       => $page->slug,
                'icon'       => $page->icon,
                'route'      => route('dashboard.pages.show', [$page->slug]),
                'label'      => $page->name,
                'childs'     => false,
                'permission' => 'dashboard.posts.type.' . $page->slug,
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


    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuSystems(Dashboard $dashboard)
    {
        $dashboard->menu->add('Systems', [
            'slug'       => 'settings',
            'icon'       => 'fa fa-cog',
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
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'section',
            'icon'       => 'icon-briefcase',
            'route'      => route('dashboard.systems.category'),
            'label'      => trans('dashboard::menu.sections'),
            'childs'     => false,
            'divider'    => true,
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
    }

    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuTrash(Dashboard $dashboard)
    {
        $dashboard->menu->add('Main', [
            'slug'       => 'Trash',
            'icon'       => 'icon-trash',
            'route'      => '#',
            'label'      => 'Удалить в 2.0',//trans('dashboard::menu.marketing'),
            'childs'     => true,
            'main'       => true,
            'active'     => 'dashboard.marketing.*',
            'permission' => 'dashboard.marketing',
            'sort'       => 1500,
        ]);

        $dashboard->menu->add('Trash', [
            'slug'       => 'utm',
            'icon'       => 'fa fa-link',
            'route'      => route('dashboard.marketing.utm.index'),
            'label'      => trans('dashboard::menu.utm'),
            'permission' => 'dashboard.marketing.utm',
            'sort'       => 10,
        ]);

        $dashboard->menu->add('Trash', [
            'slug'       => 'robots',
            'icon'       => 'fa fa-keyboard-o',
            'route'      => route('dashboard.marketing.robots.index'),
            'label'      => trans('dashboard::menu.robots'),
            'permission' => 'dashboard.marketing.robots',
            'sort'       => 15,
        ]);

        $dashboard->menu->add('Trash', [
            'slug'       => 'backup',
            'icon'       => 'fa fa-history',
            'route'      => route('dashboard.systems.backup'),
            'label'      => trans('dashboard::menu.backups'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.backup',
            'sort'       => 2,
        ]);

        $dashboard->menu->add('Trash', [
            'slug'       => 'logs',
            'icon'       => 'fa fa-bug',
            'route'      => route('dashboard.systems.logs.index'),
            'label'      => trans('dashboard::menu.logs'),
            'groupname'  => trans('dashboard::menu.errors'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.logs',
            'sort'       => 500,
        ]);

        $dashboard->menu->add('Trash', [
            'slug'       => 'defender',
            'icon'       => 'fa fa-shield',
            'route'      => route('dashboard.systems.defender.index'),
            'label'      => trans('dashboard::menu.defender'),
            'permission' => 'dashboard.systems.defender',
            'sort'       => 501,
        ]);

        $dashboard->menu->add('Trash', [
            'slug'       => 'monitor',
            'icon'       => 'fa fa-television',
            'route'      => route('dashboard.systems.monitor'),
            'label'      => trans('dashboard::menu.monitor'),
            'permission' => 'dashboard.systems.monitor',
            'sort'       => 502,
        ]);

        $dashboard->menu->add('Trash', [
            'slug'       => 'schema',
            'icon'       => 'fa fa-database',
            'route'      => route('dashboard.systems.schema.index'),
            'label'      => trans('dashboard::menu.schema'),
            'childs'     => false,
            'divider'    => true,
            'permission' => 'dashboard.systems.schema',
            'sort'       => 3,
        ]);
    }
}
