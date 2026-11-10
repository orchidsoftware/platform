<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Screen;

class ModelAutoOpenScreen extends Screen
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
        return 'Modal Open';
    }

    /**
     * Display header name.
     */
    public function description(): ?string
    {
        return 'Test screen';
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
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Modal::make('openModel', Rows::make([
                Input::make('message')
                    ->title('Messages to display')
                    ->placeholder('Hello world!')
                    ->required(),
            ]))->open()->title('Open modal message'),
        ];
    }
}
