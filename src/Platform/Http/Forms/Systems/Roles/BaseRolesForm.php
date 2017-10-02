<?php

namespace Orchid\Platform\Http\Forms\Systems\Roles;

use Illuminate\Contracts\View\View;
use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Forms\Form;

class BaseRolesForm extends Form
{
    /**
     * @var string
     */
    public $name = 'General Info';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Role::class;

    /**
     * Validation Rules Request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name'        => 'required|max:255|unique:roles,name,' . $this->request->get('name') . ',name',
            'slug'        => 'required|max:255|unique:roles,slug,' . $this->request->get('slug') . ',slug',
            'permissions' => 'array',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param Role|null $role
     *
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function get(Role $role = null) : View
    {
        if (!is_null($role)) {
            $rolePermission = $role->permissions;
            $permission = Dashboard::getPermission();
            $permission->transform(function ($array) use ($rolePermission) {
                foreach ($array as $key => $value) {
                    $array[$key]['active'] = array_key_exists($value['slug'], $rolePermission);
                }

                return $array;
            });
        } else {
            $permission = Dashboard::getPermission();
        }

        return view('dashboard::container.systems.roles.info', [
            'permission' => $permission,
            'role'       => $role,
        ]);
    }

    /**
     * Save Base Role.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist()
    {
        $role = Role::firstOrNew([
            'slug' => $this->request->get('slug'),
        ]);
        $role->fill($this->request->all());
        $role->permissions = $this->request->get('permissions') ?: [];

        $role->save();
    }

    /**
     * @param Role $role
     */
    public function delete(Role $role)
    {
        $role->delete();
    }
}
