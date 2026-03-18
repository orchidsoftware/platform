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
                ->route('orchid.example.fields'),

            Menu::make('Advanced Elements')
                ->route('orchid.example.advanced'),

            Menu::make('Text Editors')
                ->route('orchid.example.editors'),

            Menu::make('Run Actions')
                ->route('orchid.example.actions'),
        ];
    }
}
