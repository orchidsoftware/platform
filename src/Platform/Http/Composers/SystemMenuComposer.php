<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

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
                'slug'       => 'MainSystems',
                'icon'       => 'icon-layers',
                'label'      => trans('dashboard::menu.systems'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('MainSystems', [
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
            ])
            ->add('MainSystems', [
                'slug'       => 'Systems3',
                'icon'       => 'icon-layers',
                'route'      => '#',
                'label'      => trans('dashboard::menu.systems'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('MainSystems', [
                'slug'       => 'Systems4',
                'icon'       => 'icon-layers',
                'route'      => '#',
                'label'      => trans('dashboard::menu.systems'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('MainSystems', [
                'slug'       => 'Systems5',
                'icon'       => 'icon-layers',
                'route'      => '#',
                'label'      => trans('dashboard::menu.systems'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('MainSystems', [
                'slug'       => 'Systems6',
                'icon'       => 'icon-layers',
                'route'      => '#',
                'label'      => trans('dashboard::menu.systems'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Systems', [
                'slug'       => 'Cache',
                'icon'       => 'icon-refresh',
                'label'      => 'Cache configuration',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'cache:clear',
                'icon'       => 'icon-refresh',
                'route'      => route('dashboard.systems.cache', ['action' => 'cache']),
                'label'      => trans('dashboard::systems/cache.cache'),
                'groupname'  => trans('dashboard::systems/cache.cache.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'config:cache',
                'icon'       => 'icon-wrench',
                'route'      => route('dashboard.systems.cache', ['action' => 'config']),
                'label'      => trans('dashboard::systems/cache.config'),
                'groupname'  => trans('dashboard::systems/cache.config.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'route:cache',
                'icon'       => 'icon-directions',
                'route'      => route('dashboard.systems.cache', ['action' => 'route']),
                'label'      => trans('dashboard::systems/cache.route'),
                'groupname'  => trans('dashboard::systems/cache.route.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'view:clear',
                'icon'       => 'icon-monitor',
                'route'      => route('dashboard.systems.cache', ['action' => 'view']),
                'label'      => trans('dashboard::systems/cache.view'),
                'groupname'  => trans('dashboard::systems/cache.view.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'opcache:clear',
                'icon'       => 'icon-settings',
                'route'      => route('dashboard.systems.cache', ['action' => 'view']),
                'label'      => trans('dashboard::systems/cache.opcache'),
                'groupname'  => trans('dashboard::systems/cache.opcache.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Systems', [
                'slug'       => 'Auth',
                'icon'       => 'icon-lock',
                'label'      => 'Разделение прав доступа',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('Auth', [
                'slug'       => 'users',
                'icon'       => 'icon-user',
                'route'      => route('dashboard.systems.users'),
                'label'      => trans('dashboard::menu.users'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'permission' => 'dashboard.systems.users',
                'sort'       => 9,
            ])
            ->add('Auth', [
                'slug'       => 'roles',
                'icon'       => 'icon-lock',
                'route'      => route('dashboard.systems.roles'),
                'label'      => trans('dashboard::menu.roles'),
                'groupname'  => 'Как получилось, что под блокировки РКН едва не попали «ВКонтакте»',
                'permission' => 'dashboard.systems.roles',
                'sort'       => 10,
            ]);

    }
}
