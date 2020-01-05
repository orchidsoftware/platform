<?php

declare(strict_types=1);

namespace App\Orchid\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\Menu;

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
                ItemMenu::label(__('Access rights'))
                    ->icon('icon-lock')
                    ->slug('Auth')
                    ->active('platform.systems.*')
                    ->permission('platform.systems.index')
                    ->sort(1000)
            )
            ->add('Auth',
                ItemMenu::label(__('Users'))
                    ->icon('icon-user')
                    ->route('platform.systems.users')
                    ->permission('platform.systems.users')
                    ->sort(1000)
                    ->title(__('All registered users'))
            )
            ->add('Auth',
                ItemMenu::label(__('Roles'))
                    ->icon('icon-lock')
                    ->route('platform.systems.roles')
                    ->permission('platform.systems.roles')
                    ->sort(1000)
                    ->title(__('A Role defines a set of tasks a user assigned the role is allowed to perform. '))
            );
    }
}
