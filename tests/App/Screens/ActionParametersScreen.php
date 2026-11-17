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
use Orchid\Tests\App\Enums\RoleNames;

class ActionParametersScreen extends Screen
{
    public function query(): array
    {
        return [];
    }

    public function layout(): array
    {
        return [
            Layout::modal('edit', Layout::rows([
                Input::make('user.name')->title('Selected modal content'),
                Input::make('marker'),
            ]))->deferred('loadUser'),
            Layout::modal('other', Layout::rows([
                Input::make('other.name')->title('Other modal content'),
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

    public function selectProfile(User $userProfile): array
    {
        return ['selected' => $userProfile->id];
    }

    public function selectRoleName(RoleNames $roleName): array
    {
        return ['role' => $roleName->value];
    }

    public function loadUser(User $user, Repository $state): array
    {
        return ['user' => $user, 'marker' => $state->get('marker')];
    }

    public function selectRole(User $user, Role $role): array
    {
        return ['user' => $user->id, 'role' => $role->id];
    }

    public function collect(User $user, string ...$labels): array
    {
        return ['selected' => $user->id, 'labels' => $labels];
    }
}
