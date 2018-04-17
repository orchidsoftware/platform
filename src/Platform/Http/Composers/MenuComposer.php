<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Orchid\Platform\Kernel\Dashboard;

class MenuComposer
{

    /**
     * @var Dashboard
     */
    private $dashboard;

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
        $this->registerMenuSystems($this->dashboard)
            ->registerMenuPost($this->dashboard);
            //->registerMenuPage($this->dashboard);
    }

    /**
     * @param Dashboard $dashboard
     *
     * @return $this
     */
    protected function registerMenuPage(Dashboard $dashboard): MenuComposer
    {
        $allPage = $this->dashboard->getSingleBehaviors()->where('display', true)->all();

        $dashboard->menu->add('Main', [
            'slug'       => 'Posts',//'Pages',
            'icon'       => 'icon-docs',
            'route'      => '#',
            'label'      => trans('dashboard::menu.pages'),
            'childs'     => true,
            'main'       => true,
            'active'     => 'dashboard.pages.*',
            'permission' => 'dashboard.pages',
            'sort'       => 150,
            'show'       => count($allPage) > 0,
        ]);

        foreach ($allPage as $key => $page) { //Pages
            $dashboard->menu->add('Posts', [
                'slug'       => $page->slug,
                'icon'       => $page->icon,
                'route'      => route('dashboard.pages.show', [$page->slug]),
                'label'      => $page->name,
                'permission' => 'dashboard.pages.type.' . $page->slug,
                'sort'       => $key,
                'groupname'  => $page->groupname,
                'divider'    => $page->divider,
                'show'       => $page->display,
            ]);
        }

        return $this;
    }

    /**
     * @param Dashboard $dashboard
     *
     * @return $this
     */
    protected function registerMenuPost(Dashboard $dashboard): MenuComposer
    {
        $allPost = $this->dashboard->getManyBehaviors()
            ->where('display', true)
            ->all();



        $dashboard->menu->add('Main', [
            'slug'       => 'Posts',
            'icon'       => 'icon-notebook',
            'route'      => '#',
            'label'      => trans('dashboard::menu.posts'),
            'childs'     => true,
            'main'       => true,
            'active'     => ['dashboard.posts.*','dashboard.pages.*'],
            'permission' => 'dashboard.posts',
            'sort'       => 100,
            'show'       => count($allPost) > 0,
        ]);

        foreach ($allPost as $key => $page) {

            $dashboard->menu->add('Posts', [
                'slug'       => $page->slug,
                'icon'       => $page->icon,
                'route'      => route('dashboard.posts.type', [$page->slug]),
                'label'      => $page->name,
                'permission' => 'dashboard.posts.type.' . $page->slug,
                'sort'       => $key,
                'groupname'  => $page->groupname,
                'divider'    => $page->divider,
                'show'       => $page->display,
            ]);
        }



        $allPage = $this->dashboard->getSingleBehaviors()->where('display', true)->all();

        foreach ($allPage as $key => $page) { //Pages
            $dashboard->menu->add('Posts', [
                'slug'       => $page->slug,
                'icon'       => $page->icon,
                'route'      => route('dashboard.pages.show', [$page->slug]),
                'label'      => $page->name,
                'permission' => 'dashboard.pages.type.' . $page->slug,
                'sort'       => $key,
                'groupname'  => $page->groupname,
                'divider'    => $page->divider,
                'show'       => $page->display,
            ]);
        }


        return $this;
    }

    /**
     * @param Dashboard $dashboard
     *
     * @return $this
     */
    protected function registerMenuSystems(Dashboard $dashboard): MenuComposer
    {
        $dashboard->menu
            ->add('Main', [
                'slug'       => 'Systems',
                'icon'       => 'icon-layers',
                'route'      => '#',
                'label'      => trans('dashboard::menu.systems'),
                'childs'     => true,
                'main'       => true,
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Systems', [
                'slug'       => 'settings',
                'icon'       => 'icon-settings',
                'route'      => route('dashboard.systems.settings'),
                'label'      => trans('dashboard::menu.constants'),
                'groupname'  => trans('dashboard::menu.general settings'),
                'permission' => 'dashboard.systems.settings',
                'sort'       => 1,
            ])
            ->add('Systems', [
                'slug'       => 'section',
                'icon'       => 'icon-briefcase',
                'route'      => route('dashboard.systems.category'),
                'label'      => trans('dashboard::menu.sections'),
                'permission' => 'dashboard.systems.category',
                'groupname'  => trans('dashboard::menu.posts Managements'),
                'sort'       => 2,
            ])
            ->add('Systems', [
                'slug'       => 'menu',
                'icon'       => 'icon-menu',
                'route'      => route('dashboard.systems.menu.index'),
                'label'      => trans('dashboard::menu.menu'),
                'permission' => 'dashboard.systems.menu',
                'sort'       => 3,
                'show'       => count(config('platform.menu', [])) > 0,
            ])
            ->add('Systems', [
                'slug'       => 'comment',
                'icon'       => 'icon-bubbles',
                'route'      => route('dashboard.systems.comment'),
                'label'      => trans('dashboard::menu.comments'),
                'permission' => 'dashboard.systems.comment',
                'sort'       => 4,
            ])
            ->add('Systems', [
                'slug'       => 'media',
                'icon'       => 'icon-folder-alt',
                'route'      => route('dashboard.systems.media.index'),
                'label'      => trans('dashboard::menu.media'),
                'permission' => 'dashboard.systems.media',
                'sort'       => 5,
            ])
            ->add('Systems', [
                'slug'       => 'users',
                'icon'       => 'icon-user',
                'route'      => route('dashboard.systems.users'),
                'label'      => trans('dashboard::menu.users'),
                'groupname'  => trans('dashboard::menu.users'),
                'permission' => 'dashboard.systems.users',
                'sort'       => 9,
            ])
            ->add('Systems', [
                'slug'       => 'roles',
                'icon'       => 'icon-lock',
                'route'      => route('dashboard.systems.roles'),
                'label'      => trans('dashboard::menu.roles'),
                'divider'    => true,
                'permission' => 'dashboard.systems.roles',
                'sort'       => 10,
            ]);

        return $this;
    }
}
