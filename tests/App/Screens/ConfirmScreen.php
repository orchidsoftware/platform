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
     * Query data.
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Test confirm';
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
