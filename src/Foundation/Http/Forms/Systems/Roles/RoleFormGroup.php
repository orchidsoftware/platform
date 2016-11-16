<?php

namespace Orchid\Foundation\Http\Forms\Systems\Roles;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Events\Systems\RolesEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

class RoleFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = RolesEvent::class;

    /**
     * Description Attributes for group.
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Роли',
            'description' => 'Разделение прав доступа',
        ];
    }

    /**
     * Route available list.
     * @var array
     */
    public $route = [
        'index' => 'dashboard.systems.roles',
        'create' => 'dashboard.systems.roles.create',
        'edit' => 'dashboard.systems.roles.edit',
        'update' => 'dashboard.systems.roles.update',
        'store' => 'dashboard.systems.roles.store',
        'destroy' => 'dashboard.systems.roles.destroy',
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        $role = new Role();
        $roles = $role->select('name', 'slug', 'created_at')->paginate();

        return view('dashboard::container.systems.roles.grid', [
            'roles' => $roles,
        ]);
    }
}
