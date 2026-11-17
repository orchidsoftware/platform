<?php

namespace Orchid\Tests\App\Screens;

use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Screen;

class ModelRouteBindScreen extends Screen
{
    /**
     * Query data.
     *
     * @param User $user
     */
    public function query(?User $user = null): array
    {
        return [
            'user' => $user,
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
