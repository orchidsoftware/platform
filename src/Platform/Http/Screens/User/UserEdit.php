<?php

declare(strict_types=1);

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
     * Display header name.
     *
     * @var string
     */
    public $name = 'dashboard::systems/users.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'dashboard::systems/users.description';

    /**
     * Query data.
     *
     * @param int $id
     *
     * @return array
     */
    public function query(int $id = null): array
    {
        $user = is_null($id) ? new User() : User::findOrFail($id);

        $rolePermission = $user->permissions ?? [];
        $permission = Dashboard::getPermission()
            ->collapse()
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
            Link::name('назад')->link(redirect()->back()->getTargetUrl()),
            Link::name(trans('dashboard::common.commands.save'))
                ->icon('icon-check')
                ->method('save'),
            Link::name(trans('dashboard::common.commands.remove'))
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

        $user->fill($attributes);

        if ($request->filled('user.password', null)) {
            $user->password = Hash::make($request->get('user.password'));
        }

        foreach ($request->get('permissions', []) as $key => $value) {
            $permissions[base64_decode($key)] = 1;
        }

        $user->permissions = $permissions ?? [];

        $user->save();

        $roles = Role::whereIn('slug', $request->get('roles', []))->get();
        $user->replaceRoles($roles);

        Alert::info(trans('dashboard::systems/users.User was saved'));

        return redirect()->route('dashboard.systems.users');
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

        Alert::info(trans('dashboard::systems/users.User was removed'));

        return redirect()->route('dashboard.systems.users');
    }
}
