<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Throwable;

class AsyncHeaderButtonActionScreen extends Screen
{
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
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Test async button action';
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
     * @throws Throwable
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Button::make('Submit')
                    ->confirm('Do you want to press the button?')
                    ->method('message'),
            ]),
        ];
    }
}
