<?php

namespace Orchid\Tests\App\Screens;

use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ModelRouteBindScreen extends Screen
{
    /**
     * Query data.
     *
     * @param \Orchid\Platform\Models\User $user
     */
    public function query(User $user = null): array
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
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('user.id')->title('User ID'),
                Input::make('user.email')->title('User Name'),
            ]),
        ];
    }
}
