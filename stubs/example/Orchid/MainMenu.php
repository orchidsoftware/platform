<?php

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Support\Color;

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
                ->withChildren(),

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

            ItemMenu::label('Changelog')
                ->icon('shuffle')
                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                ->badge(function () {
                    return Dashboard::version();
                }, Color::DARK()),

            ItemMenu::label(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            ItemMenu::label(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }
}
