<?php

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\App\Layouts\DependentSumListener;

class FindBySlugLayoutScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'FindBySlugLayoutScreen';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            new DependentSumListener('simple'),

            Layout::columns([
                new DependentSumListener('columns-1'),

                Layout::columns([
                    new DependentSumListener('columns-2'),
                ]),
            ]),

            Layout::tabs([
                'Tab 1' => new DependentSumListener('tab-1'),
                'Tab 2' => Layout::columns([
                    new DependentSumListener('tab-2'),
                ]),
            ]),
        ];
    }

    /**
     * @return array
     */
    public function asyncStub(): array
    {
        return [];
    }
}
