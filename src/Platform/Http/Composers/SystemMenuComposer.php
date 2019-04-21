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
            ->add(Menu::SYSTEMS,
                ItemMenu::label(__('Tools'))
                    ->slug('Tools')
                    ->icon('icon-umbrella')
                    ->sort(9000)
            )
            ->add('Tools',
                ItemMenu::label(__('Public alert'))
                    ->icon('icon-bulb')
                    ->title(__('Allows you to pre-inform active users about an event.'))
                    ->route('platform.systems.announcement')
                    ->permission('platform.systems.announcement')
            );
    }
}
