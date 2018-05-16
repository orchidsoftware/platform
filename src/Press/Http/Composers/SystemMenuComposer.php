<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Dashboard;

class SystemMenuComposer
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
            ->add('Systems', [
                'slug'       => 'CMS',
                'icon'       => 'icon-layers',
                'label'      => 'Управление содержимым',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('CMS', [
                'slug'       => 'section',
                'icon'       => 'icon-briefcase',
                'route'      => route('dashboard.systems.category'),
                'label'      => trans('dashboard::menu.sections'),
                'permission' => 'dashboard.systems.category',
                'groupname'  => trans('dashboard::menu.posts Managements'),
                'sort'       => 2,
            ])
            ->add('CMS', [
                'slug'       => 'comment',
                'icon'       => 'icon-bubbles',
                'route'      => route('dashboard.systems.comment'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'label'      => trans('dashboard::menu.comments'),
                'permission' => 'dashboard.systems.comment',
                'sort'       => 4,
                'badge'      => [
                    'class' => 'bg-primary',
                    'data'  => function () {
                        return 7;
                    },
                ],
            ])
            ->add('CMS', [
                'slug'       => 'media',
                'icon'       => 'icon-folder-alt',
                'route'      => route('dashboard.systems.media.index'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'label'      => trans('dashboard::menu.media'),
                'permission' => 'dashboard.systems.media',
                'sort'       => 5,
            ])

            ->add('CMS', [
                'slug'       => 'Systems2',
                'icon'       => 'icon-layers',
                'route'      => '#',
                'label'      => trans('dashboard::menu.systems'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
                'badge'      => [
                    'class' => 'bg-primary',
                    'data'  => function () {
                        return 7;
                    },
                ],
            ]);
    }
}
