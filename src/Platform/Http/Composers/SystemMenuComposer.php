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
            ->add('SystemsMenu', [
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
            ->add('SystemsMenu', [
                'slug'       => 'SystemCache',
                'icon'       => 'icon-refresh',
                'label'      => 'Cache configuration',
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('SystemCache', [
                'slug'       => 'cache:clear',
                'icon'       => 'icon-refresh',
                'route'      => route('dashboard.systems.cache', ['action' => 'cache']),
                'label'      => trans('dashboard::systems/cache.cache'),
                'groupname'  => trans('dashboard::systems/cache.cache.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('SystemCache', [
                'slug'       => 'config:cache',
                'icon'       => 'icon-wrench',
                'route'      => route('dashboard.systems.cache', ['action' => 'config']),
                'label'      => trans('dashboard::systems/cache.config'),
                'groupname'  => trans('dashboard::systems/cache.config.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('SystemCache', [
                'slug'       => 'route:cache',
                'icon'       => 'icon-directions',
                'route'      => route('dashboard.systems.cache', ['action' => 'route']),
                'label'      => trans('dashboard::systems/cache.route'),
                'groupname'  => trans('dashboard::systems/cache.route.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('SystemCache', [
                'slug'       => 'view:clear',
                'icon'       => 'icon-monitor',
                'route'      => route('dashboard.systems.cache', ['action' => 'view']),
                'label'      => trans('dashboard::systems/cache.view'),
                'groupname'  => trans('dashboard::systems/cache.view.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ])
            ->add('SystemCache', [
                'slug'       => 'opcache:clear',
                'icon'       => 'icon-settings',
                'route'      => route('dashboard.systems.cache', ['action' => 'view']),
                'label'      => trans('dashboard::systems/cache.opcache'),
                'groupname'  => trans('dashboard::systems/cache.opcache.description'),
                'active'     => 'dashboard.systems.*',
                'permission' => 'dashboard.systems',
                'sort'       => 1000,
            ]);
    }
}
