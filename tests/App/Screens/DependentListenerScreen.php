<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\App\Layouts\DependentSumListener;

class DependentListenerScreen extends Screen
{
    /**
     * Query data.
     */
    public function query(): array
    {
        return [
            'first' => 100,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Test Dependent';
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
     * @param \Orchid\Screen\Repository $state
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Orchid\Screen\Repository
     */
    public function asyncSum(Repository $state, Request $request): Repository
    {
        return $state
            ->set('first', $request->get('first'))
            ->set('second', $request->get('second'))
            ->set('sum', $request->get('first') + $request->get('second'));
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return \Orchid\Screen\Layout[]
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
