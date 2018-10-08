<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Orchid\Platform\ItemMenu;
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
            ->add('Systems', ItemMenu::setLabel(trans('platform::systems/settings.system_menu.Cache configuration'))
                ->setSlug('Cache')
                ->setIcon('icon-refresh')
                ->setPermission('platform.systems.cache')
                ->setSort(2000))
            ->add('Cache', ItemMenu::setLabel(trans('platform::systems/cache.cache'))
                ->setIcon('icon-refresh')
                ->setRoute(route('platform.systems.cache', ['action' => 'cache']))
                ->setGroupName(trans('platform::systems/cache.cache.description'))
            )
            ->add('Cache', ItemMenu::setLabel(trans('platform::systems/cache.config'))
                ->setIcon('icon-wrench')
                ->setRoute(route('platform.systems.cache', ['action' => 'config']))
                ->setGroupName(trans('platform::systems/cache.config.description'))
            )
            ->add('Cache', ItemMenu::setLabel(trans('platform::systems/cache.route'))
                ->setIcon('icon-directions')
                ->setRoute(route('platform.systems.cache', ['action' => 'route']))
                ->setGroupName(trans('platform::systems/cache.route.description'))
            )
            ->add('Cache',
                ItemMenu::setLabel(trans('platform::systems/cache.view'))
                    ->setIcon('icon-monitor')
                    ->setRoute(route('platform.systems.cache', ['action' => 'view']))
                    ->setGroupName(trans('platform::systems/cache.view.description'))
            )
            ->add('Cache',
                ItemMenu::setLabel(trans('platform::systems/cache.opcache'))
                    ->setIcon('icon-settings')
                    ->setRoute(route('platform.systems.cache', ['action' => 'opcache']))
                    ->setGroupName(trans('platform::systems/cache.opcache.description'))
                    ->setShow(function_exists('opcache_reset'))
            )
            ->add('Systems',
                ItemMenu::setLabel('Журналирование')
                    ->setSlug('Savior')
                    ->setIcon('icon-umbrella')
                    ->setRoute(route('platform.systems.cache', ['action' => 'opcache']))
                    ->setSort(9000)
            )
            ->add('Savior',
                ItemMenu::setLabel('Резервные копии')
                    ->setIcon('icon-clock')
                    ->setGroupName('Необходимо для возможности быстрого восстановления информации в случае утери рабочей копии.')
                    ->setRoute(route('platform.systems.backups'))
                    ->setPermission('platform.systems.backups')
            )
            ->add('Savior',
                ItemMenu::setLabel('Публичное оповещение')
                    ->setIcon('icon-bulb')
                    ->setGroupName('Предварительное оповещение о каком-либо событии.')
                    ->setRoute(route('platform.systems.announcement'))
                    ->setPermission('platform.systems.announcement')
            );
    }
}
