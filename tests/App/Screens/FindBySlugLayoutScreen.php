<?php

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Tabs;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Tests\App\Layouts\DependentSumListener;

class FindBySlugLayoutScreen extends Screen
{
    /**
     * Query data.
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Display header name.
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
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            new DependentSumListener('simple'),

            Columns::make([
                new DependentSumListener('columns-1'),

                Columns::make([
                    new DependentSumListener('columns-2'),
                ]),
            ]),

            Tabs::make([
                'Tab 1' => new DependentSumListener('tab-1'),
                'Tab 2' => Columns::make([
                    new DependentSumListener('tab-2'),
                ]),
            ]),
        ];
    }

    public function asyncStub(Repository $state): Repository
    {
        return $state;
    }
}
