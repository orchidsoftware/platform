<?php

namespace Orchid\Http\Forms\Systems\Users;

use Illuminate\Contracts\View\View;
use Orchid\Core\Models\Role;
use Orchid\Core\Models\User;
use Orchid\Facades\Dashboard;
use Orchid\Forms\Form;

class AccessUserForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Permission';

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
    public function rules(): array
    {
        return [
            'permissions' => 'array',
            'roles'       => 'array',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param User|null $user
     *
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function get(User $user = null): View
    {
        if (!is_null($user)) {
            $rolePermission = $user->permissions ?: [];
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

            $userRoles->transform(function ($role) {
                $role->active = true;

                return $role;
            });

            $roles = $userRoles->union($roles);
        } else {
            $permission = Dashboard::getPermission();
            $roles = Role::all();
        }

        return view(
            'dashboard::container.systems.users.access',
            [
                'permission' => $permission,
                'user'       => $user,
                'roles'      => $roles,
            ]
        );
    }

    /**
     * Save Base Role.
     *
     * @param null $request
     * @param null $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist($request = null, $user = null)
    {
        if (!is_null($this->roles)) {
            $roles = Role::whereIn('slug', $this->roles)->get();
            $user->replaceRoles($roles);
        }
        $user->save();
    }
}
