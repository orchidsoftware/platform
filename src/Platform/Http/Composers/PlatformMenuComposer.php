<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Orchid\Platform\Dashboard;

class PlatformMenuComposer
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
        $this->dashboard->menu
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
    }
}
