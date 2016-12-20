<?php

namespace Orchid\Foundation\Http\Forms\Systems\Roles;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Services\Forms\FormGroup;
use Orchid\Foundation\Events\Systems\RolesEvent;

class RoleFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = RolesEvent::class;
    /**
     * Route available list.
     * @var array
     */
    public $route = [
        'index' => [
            'method' => 'GET',
            'name' => 'dashboard.systems.roles',
        ],
        'create' => [
            'method' => 'GET',
            'name' => 'dashboard.systems.roles.create',
        ],
        'edit' => [
            'method' => 'GET',
            'name' => 'dashboard.systems.roles.edit',
        ],
        'update' => [
            'method' => 'PUT',
            'name' => 'dashboard.systems.roles.update',
        ],
        'store' => [
            'method' => 'POST',
            'name' => 'dashboard.systems.roles.store',
        ],
        'destroy' => [
            'method' => 'DELETE',
            'name' => 'dashboard.systems.roles.destroy',
        ],
    ];

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
