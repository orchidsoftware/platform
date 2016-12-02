<?php

namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Facades\Dashboard;
use Orchid\Foundation\Services\Forms\Form;

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
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:roles,name,' . $this->request->get('name') . ',name',
            'slug' => 'required|max:255|unique:roles,slug,' . $this->request->get('slug') . ',slug',
            'permissions' => 'array',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param null $storage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($storage = null)
    {
        $role = $storage->get('model');

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
            'role' => $role,
        ]);
    }

    /**
     * Save Base Role.
     *
     * @param null $storage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist($storage = null)
    {
        $role = Role::firstOrNew([
            'slug' => $this->request->get('slug'),
        ]);
        $role->fill($this->request->all());
        $role->permissions = $this->request->get('permissions') ?: [];


        $role->save();
        Alert::success('Message');
    }

    /**
     * @param Role $role
     */
    public function delete(Role $role)
    {
        $role->delete();
        Alert::success('Message');
    }
}
