<?php

namespace Orchid\Foundation\Http\Forms\Systems\Users;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Facades\Dashboard;
use Orchid\Foundation\Services\Forms\Form;


class AccessUserForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Права доступа';

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
            'roles' => 'array',
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
            $permission = Dashboard::getPermission();


            $permission->transform(
                function ($array) use ($rolePermission) {
                    foreach ($array as $key => $value) {
                        $array[$key]['active'] = array_key_exists($value['slug'], $rolePermission);
                    }

                    return $array;
                }
            );


            $roles = Role::all();
            $userRoles = $user->getRoles();


            if(!$userRoles->isEmpty()) {
                $roles->transform(
                    function ($role) use ($userRoles) {
                        foreach ($userRoles as $userRole) {
                            $role->active = ($userRole->slug == $role->slug);

                            return $role;
                        }
                    }
                );
            }

        } else {
            $permission = Dashboard::getPermission();
            $roles = Role::all();
        }

        return view(
            'dashboard::container.systems.users.access',
            [
                'permission' => $permission,
                'user' => $user,
                'roles' => $roles,
            ]
        );
    }

    /**
     * Save Base Role.
     *
     * @param null $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist($user = null)
    {
        $roles = Role::whereIn('slug',$this->roles)->get();
        $user->replaceRoles($roles);
        $user->save();
        Alert::success('Message');
    }
}
