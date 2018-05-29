<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\User;

use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Platform\Screen\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Platform\Screen\Screen;
use Orchid\Platform\Screen\Layouts;
use Illuminate\Support\Facades\Hash;
use Orchid\Support\Facades\Dashboard;
use Orchid\Platform\Http\Layouts\User\UserEditLayout;
use Orchid\Platform\Http\Layouts\User\UserRoleLayout;

class UserEdit extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::systems/users.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/users.description';

    /**
     * Query data.
     *
     * @param int $id
     *
     * @return array
     */
    public function query(int $id): array
    {
        $user = is_null($id) ? new User() : User::findOrFail($id);

        $rolePermission = $user->permissions ?? [];
        $permission = Dashboard::getPermission()
            ->sort()
            ->transform(function ($group) use ($rolePermission) {
                $group = collect($group)->sortBy('description')->toArray();

                foreach ($group as $key => $value) {
                    $group[$key]['active'] = array_key_exists($value['slug'], $rolePermission);
                }

                return $group;
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
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(trans('platform::common.commands.save'))
                ->icon('icon-check')
                ->method('save'),
            Link::name(trans('platform::common.commands.remove'))
                ->icon('icon-trash')
                ->method('remove'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layouts::columns([
                'Left column'  => [
                    UserEditLayout::class,
                ],
                'Right column' => [
                      UserRoleLayout::class,
                ],
            ]),
        ];
    }

    /**
     * @param         $id
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save($id, Request $request)
    {
        $user = User::findOrNew($id);

        $attributes = $request->get('user');

        if (array_key_exists('password', $attributes) && empty($attributes['password'])) {
            unset($attributes['password']);
        }

        if ($request->filled('user.password', null)) {
            $user->password = Hash::make($request->get('user.password'));
        }

        foreach ($request->get('permissions', []) as $key => $value) {
            $permissions[base64_decode($key)] = 1;
        }

        $user->permissions = $permissions ?? [];

        $user->fill($attributes)->save();

        $roles = Role::whereIn('slug', $request->get('roles', []))->get();
        $user->replaceRoles($roles);

        Alert::info(trans('platform::systems/users.User was saved'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        $user = User::findOrNew($id);

        $user->delete();

        Alert::info(trans('platform::systems/users.User was removed'));

        return redirect()->route('platform.systems.users');
    }
}
