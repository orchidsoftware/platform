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
            'slug'       => 'users',
            'icon'       => 'icon-user',
            'route'      => route('dashboard.systems.users'),
            'label'      => trans('dashboard::menu.users'),
            'groupname'  => trans('dashboard::menu.users'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.users',
            'sort'       => 503,
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'roles',
            'icon'       => 'fa fa-lock',
            'route'      => route('dashboard.systems.roles'),
            'label'      => trans('dashboard::menu.roles'),
            'childs'     => false,
            'divider'    => true,
            'permission' => 'dashboard.systems.roles',
            'sort'       => 601,
        ]);
    }
}
