<?php

namespace Orchid\Tests\App\Screens;

use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Screen;

class ModelRouteParamBindScreen extends Screen
{
    /**
     * Query data.
     *
     * @param User $bind
     */
    public function query(?User $bind = null): array
    {
        return [
            'user' => $bind,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'ModelRouteBindScreen';
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
            Rows::make([
                Input::make('user.id')->title('User ID'),
                Input::make('user.email')->title('User Name'),
            ]),
        ];
    }
}
