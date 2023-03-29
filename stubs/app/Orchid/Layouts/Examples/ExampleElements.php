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
            Menu::make('Basic Elements')
                ->route('platform.example.fields'),

            Menu::make('Advanced Elements')
                ->route('platform.example.advanced'),

            Menu::make('Text Editors')
                ->route('platform.example.editors'),

            Menu::make('Run Actions')
                ->route('platform.example.actions'),
        ];
    }
}
