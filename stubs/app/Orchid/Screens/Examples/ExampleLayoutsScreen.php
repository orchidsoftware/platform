<?php

namespace App\Orchid\Screens\Examples;

use App\Orchid\Layouts\Examples\TabMenuExample;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Accordion;
use Orchid\Screen\Layouts\Block;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Tabs;
use Orchid\Screen\Layouts\View;
use Orchid\Screen\Screen;

class ExampleLayoutsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Layout Overview';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A guide to designing and implementing layout options, from basics to advanced.';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @throws \Throwable
     *
     * @return Layout[]
     */
    public function layout(): iterable
    {
        return [

            Block::make(View::make('orchid::dummy.block'))
                ->title('Block Header')
                ->description('Excellent description that editing or views in block'),

            Tabs::make([
                'Example Tab 1' => View::make('orchid::dummy.block'),
                'Example Tab 2' => View::make('orchid::dummy.block'),
                'Example Tab 3' => View::make('orchid::dummy.block'),
            ]),

            TabMenuExample::class,
            View::make('orchid::dummy.block'),

            Columns::make([
                View::make('orchid::dummy.block'),
                View::make('orchid::dummy.block'),
                View::make('orchid::dummy.block'),
            ]),

            Accordion::make([
                'Collapsible Group Item #1' => View::make('orchid::dummy.block'),
                'Collapsible Group Item #2' => View::make('orchid::dummy.block'),
                'Collapsible Group Item #3' => View::make('orchid::dummy.block'),
            ]),

        ];
    }
}
