<?php

namespace Orchid\Http\Forms\Systems\Roles;

use Illuminate\Contracts\View\View;
use Orchid\Core\Models\Role;
use Orchid\Events\Systems\RolesEvent;
use Orchid\Forms\FormGroup;

class RoleFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = RolesEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'        => trans('dashboard::systems/roles.title'),
            'description' => trans('dashboard::systems/roles.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main(): View
    {
        $role = new Role();
        $roles = $role->select('name', 'slug', 'created_at')->paginate();

        return view('dashboard::container.systems.roles.grid', [
            'roles' => $roles,
        ]);
    }
}
