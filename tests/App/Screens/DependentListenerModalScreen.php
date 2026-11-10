<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
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
     * Views.
     *
     * @throws \Throwable
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Modal::make('modal-listener', [
                DependentSumListener::class,
            ])->title('Listener in modal'),
        ];
    }
}
