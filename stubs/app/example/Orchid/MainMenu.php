<?php

namespace App\Orchid;

use Orchid\Platform\ItemMenu;

class MainMenu
{

    public static function menu()
    {
        return [
            ItemMenu::label('Example screen')
                ->icon('monitor')
                ->route('platform.example')
                ->title('Navigation')
                ->badge(function () {
                    return 6;
                }),

            ItemMenu::label('Dropdown menu')
                ->slug('example-menu')
                ->icon('code')
                ->childs(),

            ItemMenu::label('Sub element item 1')
                ->place('example-menu')
                ->icon('bag'),

            ItemMenu::label('Sub element item 2')
                ->place('example-menu')
                ->icon('heart'),

            ItemMenu::label('Basic Elements')
                ->title('Form controls')
                ->icon('note')
                ->route('platform.example.fields'),

            ItemMenu::label('Advanced Elements')
                ->icon('briefcase')
                ->route('platform.example.advanced'),

            ItemMenu::label('Text Editors')
                ->icon('list')
                ->route('platform.example.editors'),

            ItemMenu::label('Overview layouts')
                ->title('Layouts')
                ->icon('layers')
                ->route('platform.example.layouts'),

            ItemMenu::label('Chart tools')
                ->icon('bar-chart')
                ->route('platform.example.charts'),

            ItemMenu::label('Cards')
                ->icon('grid')
                ->route('platform.example.cards'),

            ItemMenu::label('Documentation')
                ->title('Docs')
                ->icon('docs')
                ->url('https://orchid.software/en/docs'),
        ];
    }
}