<?php

namespace App\Orchid\Layouts\Examples;

use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Layouts\TabMenu;

class ExampleElements extends TabMenu
{
    /**
     * Get the menu elements to be displayed.
     *
     * @return Menu[]
     */
    protected function navigations(): iterable
    {
        return [
            /*
            Menu::make('Get Started')
                ->route('platform.main'),
            */

            Menu::make('Basic Elements')
                //->icon('bs.journal')
                ->route('platform.example.fields'),

            Menu::make('Advanced Elements')
                //->icon('bs.briefcase')
                ->route('platform.example.advanced'),

            Menu::make('Text Editors')
               // ->icon('bs.list')
                ->route('platform.example.editors'),

            Menu::make('Run Actions')
                //->icon('bs.list')
                ->route('platform.example.actions'),
        ];
    }
}
