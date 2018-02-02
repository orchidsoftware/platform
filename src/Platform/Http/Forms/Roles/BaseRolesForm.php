<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Systems\Roles;

use Orchid\Platform\Forms\Form;
use Illuminate\Contracts\View\View;
use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Facades\Dashboard;

class BaseRolesForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Information';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Role::class;

    /**
     * BaseRolesForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('dashboard::systems/roles.tabs.information');
        parent::__construct($request);
    }

    /**
     * Validation Rules Request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name'        => 'required|max:255|unique:roles,name,'.$this->request->get('name').',name',
            'slug'        => 'required|max:255|unique:roles,slug,'.$this->request->get('slug').',slug',
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
        if (! is_null($role)) {
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
     * @return void
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
