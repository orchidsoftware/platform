<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Tests\App\Layouts\DependentSumListener;

class DependentListenerScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Test Dependent';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'first' => 100,
        ];
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
     * @param int $first
     * @param int $b
     *
     * @return int[]
     */
    public function asyncSum(int $first, int $second): array
    {
        return [
            'first'  => $first,
            'second' => $second,
            'sum'    => $first + $second,
        ];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('first')
                    ->title('First argument')
                    ->type('number'),

                Input::make('second')
                    ->title('Second argument')
                    ->type('number'),
            ]),

            DependentSumListener::class,
        ];
    }
}
