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
                'slug'       => 'Cache',
                'icon'       => 'icon-refresh',
                'label'      => trans('platform::systems/settings.system_menu.Cache configuration'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 2000,
            ])
            ->add('Cache', [
                'slug'       => 'cache:clear',
                'icon'       => 'icon-refresh',
                'route'      => route('platform.systems.cache', ['action' => 'cache']),
                'label'      => trans('platform::systems/cache.cache'),
                'groupname'  => trans('platform::systems/cache.cache.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'config:cache',
                'icon'       => 'icon-wrench',
                'route'      => route('platform.systems.cache', ['action' => 'config']),
                'label'      => trans('platform::systems/cache.config'),
                'groupname'  => trans('platform::systems/cache.config.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'route:cache',
                'icon'       => 'icon-directions',
                'route'      => route('platform.systems.cache', ['action' => 'route']),
                'label'      => trans('platform::systems/cache.route'),
                'groupname'  => trans('platform::systems/cache.route.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'view:clear',
                'icon'       => 'icon-monitor',
                'route'      => route('platform.systems.cache', ['action' => 'view']),
                'label'      => trans('platform::systems/cache.view'),
                'groupname'  => trans('platform::systems/cache.view.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
            ])
            ->add('Cache', [
                'slug'       => 'opcache:clear',
                'icon'       => 'icon-settings',
                'route'      => route('platform.systems.cache', ['action' => 'opcache']),
                'label'      => trans('platform::systems/cache.opcache'),
                'groupname'  => trans('platform::systems/cache.opcache.description'),
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems.cache',
                'sort'       => 1000,
                'show'       => function_exists('opcache_reset'),
            ])
            ->add('Systems', [
                'slug'       => 'Savior',
                'icon'       => 'icon-umbrella',
                'label'      => 'Журналирование',
                'active'     => 'platform.systems.*',
                'permission' => 'platform.systems',
                'sort'       => 9000,
            ])
            ->add('Savior', [
                'slug'       => 'backups',
                'icon'       => 'icon-clock',
                'route'      => route('platform.systems.backups'),
                'label'      => 'Резервные копии',
                'groupname'  => 'Необходимо для возможности быстрого восстановления информации в случае утери рабочей копии.',
                'childs'     => false,
                'divider'    => false,
                'permission' => 'platform.systems.backups',
                'sort'       => 1,
            ])
            ->add('Savior', [
                'slug'       => 'activity-log',
                'icon'       => 'icon-action-undo',
                'route'      => route('platform.systems.backups'),
                'label'      => 'Журнал активности',
                'groupname'  => 'Наглядное представление о том, над чем работали вы и другие участники проекта – в хронологическом порядке.',
                'childs'     => false,
                'divider'    => false,
                'permission' => 'platform.systems.backups',
                'sort'       => 1,
            ])
            ->add('Savior', [
                'slug'       => 'announcement',
                'icon'       => 'icon-bulb',
                'route'      => route('platform.systems.announcement'),
                'label'      => 'Публичное оповещение',
                'groupname'  => 'Предварительное оповещение о каком-либо событии.',
                'childs'     => false,
                'divider'    => false,
                'permission' => 'platform.systems.announcement',
                'sort'       => 1,
            ]);
    }
}
