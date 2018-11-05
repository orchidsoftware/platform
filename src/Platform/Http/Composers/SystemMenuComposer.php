<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;

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
            ->add('Systems', ItemMenu::setLabel(__('Cache configuration'))
                ->setSlug('Cache')
                ->setIcon('icon-refresh')
                ->setPermission('platform.systems.cache')
                ->setSort(2000))
            ->add('Cache', ItemMenu::setLabel(__('Clear cache'))
                ->setIcon('icon-refresh')
                ->setRoute(route('platform.systems.cache', ['action' => 'cache']))
                ->setGroupName(__('Clear application cache'))
            )
            ->add('Cache', ItemMenu::setLabel(__('Clear configuration settings'))
                ->setIcon('icon-wrench')
                ->setRoute(route('platform.systems.cache', ['action' => 'config']))
                ->setGroupName(__('Create a cache file for faster configuration downloads'))
            )
            ->add('Cache', ItemMenu::setLabel(__('Clear Routes'))
                ->setIcon('icon-directions')
                ->setRoute(route('platform.systems.cache', ['action' => 'route']))
                ->setGroupName(__('Create a route cache file for faster route registration'))
            )
            ->add('Cache',
                ItemMenu::setLabel(__('Clear displayed files'))
                    ->setIcon('icon-monitor')
                    ->setRoute(route('platform.systems.cache', ['action' => 'view']))
                    ->setGroupName(__('Clear all compiled view files'))
            )
            ->add('Cache',
                ItemMenu::setLabel(__('Clear opcache'))
                    ->setIcon('icon-settings')
                    ->setRoute(route('platform.systems.cache', ['action' => 'opcache']))
                    ->setGroupName(__('Clears the contents of the operation transaction cache'))
                    ->setShow(function_exists('opcache_reset'))
            )
            ->add('Systems',
                ItemMenu::setLabel(__('Tools'))
                    ->setSlug('Tools')
                    ->setIcon('icon-umbrella')
                    ->setRoute(route('platform.systems.cache', ['action' => 'opcache']))
                    ->setSort(9000)
            )
            ->add('Tools',
                ItemMenu::setLabel(__('Backups'))
                    ->setIcon('icon-clock')
                    ->setGroupName('It is necessary for the ability to quickly recover information in case of loss of a working copy.')
                    ->setRoute(route('platform.systems.backups'))
                    ->setPermission('platform.systems.backups')
            )
            ->add('Tools',
                ItemMenu::setLabel(__('Public alert'))
                    ->setIcon('icon-bulb')
                    ->setGroupName('Allows you to pre-inform active users about any event.')
                    ->setRoute(route('platform.systems.announcement'))
                    ->setPermission('platform.systems.announcement')
            );
    }
}
