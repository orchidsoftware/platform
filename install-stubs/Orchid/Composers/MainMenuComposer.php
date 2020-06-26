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
                    ->icon('compass')
                    ->badge(function () {
                        return 6;
                    })
            )
            ->add(Menu::PROFILE,
                ItemMenu::label('Another action')
                    ->icon('heart')
            );

        // Main
        $this->dashboard->menu
            ->add(Menu::MAIN,
                ItemMenu::label('Example screen')
                    ->icon('monitor')
                    ->route('platform.example')
                    ->title('Navigation')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Dropdown menu')
                    ->slug('example-menu')
                    ->icon('code')
                    ->childs()
            )
            ->add('example-menu',
                ItemMenu::label('Sub element item 1')
                    ->icon('bag')
            )
            ->add('example-menu',
                ItemMenu::label('Sub element item 2')
                    ->icon('heart')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Basic Elements')
                    ->title('Form controls')
                    ->icon('note')
                    ->route('platform.example.fields')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Advanced Elements')
                    ->icon('briefcase')
                    ->route('platform.example.advanced')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Text Editors')
                    ->icon('list')
                    ->route('platform.example.editors')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Overview layouts')
                    ->title('Layouts')
                    ->icon('layers')
                    ->route('platform.example.layouts')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Chart tools')
                    ->icon('bar-chart')
                    ->route('platform.example.charts')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Cards')
                    ->icon('grid')
                    ->route('platform.example.cards')
            )
            ->add(Menu::MAIN,
                ItemMenu::label('Documentation')
                    ->title('Docs')
                    ->icon('docs')
                    ->url('https://orchid.software/en/docs')
            );
    }
}
