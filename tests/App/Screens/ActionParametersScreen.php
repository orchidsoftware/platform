<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Tests\App\Enums\RoleNames;

class ActionParametersScreen extends Screen
{
    public function query(): array
    {
        return [];
    }

    public function commandBar(): array
    {
        return [
            ModalToggle::make('Preview filters')
                ->modal('other', ['label' => 'Review & edit', 'filters' => ['statuses' => ['active', 'invited']]])
                ->method('applyFilters'),
        ];
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
                Input::make('filters.statuses.1'),
            ]))->deferred('previewFilters'),
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

    public function selectProfile(?User $userProfile = null): array
    {
        return ['selected' => $userProfile?->id];
    }

    public function selectRoleName(RoleNames $roleName): array
    {
        return ['role' => $roleName->value];
    }

    public function loadUser(User $user, Repository $state): array
    {
        return ['user' => $user, 'marker' => $state->get('marker')];
    }

    public function previewFilters(string $label, array $filters): array
    {
        return ['other' => ['name' => $label], 'filters' => $filters];
    }

    public function applyFilters(string $label, array $filters): void
    {
        Toast::info($label.': '.implode(', ', $filters['statuses']));
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
