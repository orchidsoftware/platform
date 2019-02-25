<?php

declare(strict_types=1);

namespace App\Orchid\Composers;

use Orchid\Platform\Menu;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\Dashboard;

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
                ItemMenu::setLabel('Example 1')
                    ->setIcon('icon-compass')
            )
            ->add(Menu::PROFILE,
                ItemMenu::setLabel('Example 2')
                    ->setIcon('icon-heart')
                    ->setBadge(function () {
                        return 6;
                    })
            )
            ->add(Menu::PROFILE,
                ItemMenu::setLabel('Example 3')
                    ->setIcon('icon-microphone')
            );

        // Main
        $this->dashboard->menu
            ->add(Menu::MAIN,
                ItemMenu::setLabel('Example 4')
                    ->setIcon('icon-folder')
                    ->setRoute('platform.example')
                    ->setGroupName('Example boilerplate')
            )
            ->add(Menu::MAIN,
                ItemMenu::setLabel('Example 5 menu')
                    ->setSlug('example-menu')
                    ->setIcon('icon-heart')
                    ->setChilds()
            )
            ->add('example-menu',
                ItemMenu::setLabel('Example sub 1')
                    ->setIcon('icon-bag')
                    ->setRoute('platform.example')
            )
            ->add('example-menu',
                ItemMenu::setLabel('Example sub 2')
                    ->setIcon('icon-heart')
                    ->setRoute('platform.example')
                    ->setGroupName('Separate')
            )
            ->add(Menu::MAIN,
                ItemMenu::setLabel('Example 6')
                    ->setIcon('icon-code')
                    ->setRoute('platform.example')
            )
            ->add(Menu::MAIN,
                ItemMenu::setLabel('Example 7')
                    ->setIcon('icon-bag')
                    ->setRoute('platform.example')
            )
            ->add(Menu::MAIN,
                ItemMenu::setLabel('Example 8')
                    ->setIcon('icon-folder')
                    ->setRoute('platform.example')
            );
    }
}
