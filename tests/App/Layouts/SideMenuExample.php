<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Layouts\SideMenu;
use Orchid\Support\Color;

class SideMenuExample extends SideMenu
{
    protected function label(): string
    {
        return 'Workspace navigation';
    }

    protected function navigations(): iterable
    {
        return [
            Menu::make('Overview')
                ->icon('bs.house')
                ->route('test.side-menu'),

            Menu::make('Recent activity')
                ->icon('bs.clock-history')
                ->route('test.side-menu.activity')
                ->badge(fn () => 12, Color::PRIMARY),

            Menu::make('Workspace settings')
                ->icon('bs.gear')
                ->list([
                    Menu::make('General')
                        ->route('test.side-menu.settings.general'),
                    Menu::make('Members and permissions')
                        ->route('test.side-menu.settings.members'),
                ]),

            Menu::make('Notifications and preferences')
                ->icon('bs.text-wrap')
                ->route('test.side-menu.long-label')
                ->divider(),

            Menu::make('Support')
                ->icon('bs.life-preserver')
                ->route('test.side-menu.support'),
        ];
    }
}
