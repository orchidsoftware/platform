<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Composers;

use Orchid\Platform\Menu;
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
            ->add(Menu::SYSTEMS, ItemMenu::label(__('Cache configuration'))
                ->slug('Cache')
                ->icon('icon-refresh')
                ->permission('platform.systems.cache')
                ->sort(2000))
            ->add('Cache', ItemMenu::label(__('Clear cache'))
                ->icon('icon-refresh')
                ->route('platform.systems.cache', ['action' => 'cache'])
                ->groupName(__('Clear application cache'))
            )
            ->add('Cache', ItemMenu::label(__('Clear configuration settings'))
                ->icon('icon-wrench')
                ->route('platform.systems.cache', ['action' => 'config'])
                ->groupName(__('Create a cache file for faster configuration downloads'))
            )
            ->add('Cache', ItemMenu::label(__('Clear Routes'))
                ->icon('icon-directions')
                ->route('platform.systems.cache', ['action' => 'route'])
                ->groupName(__('Create a route cache file for faster route registration'))
            )
            ->add('Cache',
                ItemMenu::label(__('Clear displayed files'))
                    ->icon('icon-monitor')
                    ->route('platform.systems.cache', ['action' => 'view'])
                    ->groupName(__('Clear all compiled view files'))
            )
            ->add(Menu::SYSTEMS,
                ItemMenu::label(__('Tools'))
                    ->slug('Tools')
                    ->icon('icon-umbrella')
                    ->route('platform.systems.cache', ['action' => 'opcache'])
                    ->sort(9000)
            )
            ->add('Tools',
                ItemMenu::label(__('Public alert'))
                    ->icon('icon-bulb')
                    ->groupName(__('Allows you to pre-inform active users about an event.'))
                    ->route('platform.systems.announcement')
                    ->permission('platform.systems.announcement')
            );
    }
}
