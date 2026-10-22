<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\App\Layouts\SideMenuExample;

class SideMenuScreen extends Screen
{
    private const PAGES = [
        'test.side-menu' => [
            'title'       => 'Overview',
            'description' => 'A summary of the workspace and its recent changes.',
        ],
        'test.side-menu.activity' => [
            'title'       => 'Recent activity',
            'description' => 'The latest changes made by people in this workspace.',
        ],
        'test.side-menu.settings.general' => [
            'title'       => 'General settings',
            'description' => 'Basic workspace details and preferences.',
        ],
        'test.side-menu.settings.members' => [
            'title'       => 'Members and permissions',
            'description' => 'Manage workspace access and member roles.',
        ],
        'test.side-menu.long-label' => [
            'title'       => 'Long navigation label',
            'description' => 'An example used to verify wrapping at intermediate widths.',
        ],
        'test.side-menu.support' => [
            'title'       => 'Support',
            'description' => 'Resources for getting help with the workspace.',
        ],
    ];

    public function query(): iterable
    {
        return [
            'page' => self::PAGES[request()->route()?->getName() ?? 'test.side-menu'],
        ];
    }

    public function name(): ?string
    {
        return 'Side menu';
    }

    public function description(): ?string
    {
        return 'A responsive SideMenu backed by named routes';
    }

    public function layout(): iterable
    {
        return [
            Layout::split([
                SideMenuExample::class,
                Layout::view('exemplar::side-menu-content'),
            ])->ratio('40/60'),
        ];
    }
}
