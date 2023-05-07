<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\App\Layouts\NestedTargetsDependentSumListener;

class NestedTargetsDependentSumListenerScreen extends Screen
{
    /**
     * Query data.
     */
    public function query(): array
    {
        return [
            'father' => [
                'first' => 100,
            ],
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Test child Dependent';
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
     * @throws \Throwable
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('father.first')
                    ->title('First argument')
                    ->type('number'),

                Input::make('father.second')
                    ->title('Second argument')
                    ->type('number'),
            ]),

            NestedTargetsDependentSumListener::class,
        ];
    }
}
