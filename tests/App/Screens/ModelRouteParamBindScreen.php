<?php

namespace Orchid\Tests\App\Screens;

use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ModelRouteParamBindScreen extends Screen
{
    /**
     * Query data.
     *
     * @param \Orchid\Platform\Models\User $bind
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
