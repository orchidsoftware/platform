<?php

namespace App\Orchid\Screens\Examples;

use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

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
        $template = Layout::view('platform::dummy.block');

        return [
            Layout::split([
                $template,
                $template,
            ])->ratio('30/70')->reverseOnPhone(),

            Layout::split([
                $template,
                $template,
            ])->ratio('40/60'),

            Layout::split([
                $template,
                $template,
            ])->ratio('50/50'),

            Layout::split([
                $template,
                $template,
            ])->ratio('60/40'),

            Layout::split([
                $template,
                $template,
            ])->ratio('70/30'),
        ];
    }
}
