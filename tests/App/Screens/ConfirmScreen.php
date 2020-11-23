<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Throwable;

class ConfirmScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Test confirm';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Submit')
                ->confirm('Do you want to press the button?')
                ->method('message'),
        ];
    }

    /**
     * Views.
     *
     * @throws Throwable
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [];
    }

    public function message()
    {
        Alert::info('Action completed');
    }
}
