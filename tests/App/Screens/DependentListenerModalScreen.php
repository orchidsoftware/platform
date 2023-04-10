<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\App\Layouts\DependentSumListener;

class DependentListenerModalScreen extends Screen
{
    /**
     * @var string
     */
    public $name;

    /**
     * Query data.
     */
    public function query(): array
    {
        return [
            'name'  => 'Test Dependent in Modal',
            'first' => 100,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make('Open Listener Modal')
                ->modal('modal-listener'),
        ];
    }

    /**
     * @param int $first
     *
     * @return int[]
     */
    public function asyncSum(int $first = null, int $second = null): array
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
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::modal('modal-listener', [
                Layout::rows([
                    Input::make('first')
                        ->title('First argument')
                        ->type('number'),

                    Input::make('second')
                        ->title('Second argument')
                        ->type('number'),
                ]),

                DependentSumListener::class,
            ])->title('Listener in modal'),
        ];
    }
}
