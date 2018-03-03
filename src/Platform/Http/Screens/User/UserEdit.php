<?php

namespace Orchid\Platform\Http\Screens\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Http\Layouts\User\UserEditLayout;
use Orchid\Platform\Http\Layouts\User\UserRoleLayout;
use Orchid\Platform\Screen\Layouts;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;

class UserEdit extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'dashboard::systems/users.title';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'dashboard::systems/users.description';

    /**
     * Query data
     *
     * @param int $userId
     *
     * @return array
     */
    public function query(int $userId = null): array
    {
        $user = is_null($userId) ? new User : User::findOrFail($userId);

        $rolePermission = $user->permissions ?? [];
        $permission = Dashboard::getPermission();

        $permission->transform(function ($array) use ($rolePermission) {
            foreach ($array as $key => $value) {
                $array[$key]['active'] = array_key_exists($value['slug'], $rolePermission);
            }
            return $array;
        });
        $roles = Role::all();
        $userRoles = $user->getRoles();

        $userRoles->transform(function ($role) {
            $role->active = true;

            return $role;
        });

        $roles = $userRoles->union($roles);

        return [
            'permission' => $permission,
            'user'       => $user,
            'roles'      => $roles,
        ];

    }

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name('Save')->method('save'),
            Link::name('Remove')->method('remove'),
        ];
    }

    /**
     * Views
     *
     * @return array
     */

    public function layout(): array
    {
        return [
            Layouts::tabs([
                trans('dashboard::systems/users.tabs.information') => [
                    UserEditLayout::class
                ],
                trans('dashboard::systems/users.tabs.permission')  => [
                    UserRoleLayout::class
                ],
            ]),

        ];
    }

    /**
     * @param         $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save($id, Request $request)
    {
        $user = User::findOrNew($id);

        $attributes = $request->get('user');

        if (array_key_exists('password', $attributes) && empty($attributes['password'])) {
            unset($attributes['password']);
        }

        $user->fill($attributes);

        if ($request->filled('user.password', null)) {
            $user->password = Hash::make($request->get('user.password'));
        }

        $roles = Role::whereIn('slug', $request->get('roles',[]))->get();
        $user->replaceRoles($roles);

        foreach ($request->get('permissions',[]) as $key => $value){
            if((int) $value){
                $permissions[base64_decode($key)] = (int) $value;
            }
        }

        $user->permissions = $permissions ?? [];

        $user->save();

        Alert::info('User was saved');

        return redirect()->route('dashboard.systems.users');
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */

    public function remove(User $user)
    {
        $user->delete();

        Alert::info('User was removed');

        return redirect()->route('dashboard.systems.users');
    }

}
