<?php

declare(strict_types=1);

namespace App\Orchid\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\Menu;

class MainMenuComposer
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
        // Profile
        $this->dashboard->menu
            ->add(Menu::PROFILE,
                ItemMenu::label('Action')
                    ->icon('icon-compass')
                    ->badge(function () {
                        return 6;
                    })
            )
            ->add(Menu::PROFILE,
                ItemMenu::label('Another action')
                    ->icon('icon-heart')
            );

        // Main
        $this->dashboard->menu
            ->add(Menu::MAIN,
                ItemMenu::label('Example screen')
                    ->icon('icon-monitor')
                    ->route('platform.example')
                    ->title('Navigation')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Form controls')
                    ->icon('icon-list')
                    ->route('platform.example.fields')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Overview layouts')
                    ->icon('icon-layers')
                    ->route('platform.example.layouts')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Screen contents')
                    ->icon('icon-folder')
                    ->route('platform.example.contents')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Dropdown menu')
                    ->title('Sub menu')
                    ->slug('example-menu')
                    ->icon('icon-code')
                    ->childs()
            )
            ->add('example-menu',
                ItemMenu::label('Sub element item 1')
                    ->icon('icon-bag')
            )
            ->add('example-menu',
                ItemMenu::label('Sub element item 2')
                    ->icon('icon-heart')
            );
    }
}
