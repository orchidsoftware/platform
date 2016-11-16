<?php

namespace Orchid\Foundation\Http\Forms\Systems\Users;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Facades\Dashboard;
use Orchid\Foundation\Services\Forms\Form;

class BaseUserForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Общие настройки';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = User::class;

    /**
     * Validation Rules Request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
        $user = $storage->get('model');


        if (!is_null($user)) {
            $rolePermission = $user->permissions;
            $permission = Dashboard::getPermission()->toArray();


            foreach ($permission as $name => $array) {
                foreach ($array as $key => $value) {
                    if (array_key_exists($value['slug'], $rolePermission)) {
                        $permission[$name][$key]['active'] = 1;
                    }
                }
            }

            $permission = collect($permission);

        } else {
            $permission = Dashboard::getPermission();
            $roles = Role::all();
        }

        return view('dashboard::container.systems.users.access', [
            'permission' => $permission,
            'user'       => $user,
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
}
