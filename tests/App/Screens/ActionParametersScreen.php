<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ActionParametersScreen extends Screen
{
    public function layout(): array
    {
        return [
            Layout::modal('edit', Layout::rows([
                Input::make('user.name'),
                Input::make('marker'),
            ]))->deferred('loadUser'),
        ];
    }

    public function select(User $user, Request $request): array
    {
        return [
            'selected'   => $user->id,
            'route_user' => $request->route('user'),
            'action'     => $request->route()->getActionName(),
        ];
    }

    public function loadUser(User $user, Repository $state): array
    {
        return ['user' => $user, 'marker' => $state->get('marker')];
    }

    public function selectRole(User $user, Role $role): array
    {
        return ['user' => $user->id, 'role' => $role->id];
    }
}
