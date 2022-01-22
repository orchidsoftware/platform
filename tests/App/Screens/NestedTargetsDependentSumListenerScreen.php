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
     *
     * @return array
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
     *
     * @return string|null
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

    public function asyncSum(Request $request): array
    {
        $first = (int) $request->input('father.first');
        $second = (int) $request->input('father.second');

        return [
            'father' => [
                'first'  => $first,
                'second' => $second,
            ],
            'sum' => $first + $second,
        ];
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
