<?php

namespace App\Orchid\Screens\Examples;

use Orchid\Screen\Action;
use Orchid\Screen\Layouts\Split;
use Orchid\Screen\Layouts\View;
use Orchid\Screen\Screen;

class ExampleGridScreen extends Screen
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
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Grid System';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Use powerful grid to build layouts';
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
     * @return array
     */
    public function layout(): iterable
    {
        $template = View::make('orchid::dummy.block');

        return [
            Split::make([
                $template,
                $template,
            ])->ratio('30/70')->reverseOnPhone(),

            Split::make([
                $template,
                $template,
            ])->ratio('40/60'),

            Split::make([
                $template,
                $template,
            ])->ratio('50/50'),

            Split::make([
                $template,
                $template,
            ])->ratio('60/40'),

            Split::make([
                $template,
                $template,
            ])->ratio('70/30'),
        ];
    }
}
