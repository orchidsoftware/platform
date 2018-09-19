<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Dashboard;
use App\Orchid\Layouts\Role\RoleEditLayout;
use App\Orchid\Layouts\Role\RolePermissionLayout;

class RoleEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::systems/roles.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/roles.description';

    /**
     * Query data.
     *
     * @param null $role
     * @return array
     */
    public function query($role = null): array
    {
        $role = is_null($role) ? new Role : $role;

        $rolePermission = $role->permissions ?? [];
        $permission = Dashboard::getPermission()
            ->sort()
            ->transform(function ($group) use ($rolePermission) {
                $group = collect($group)->sortBy('description')->toArray();

                foreach ($group as $key => $value) {
                    $group[$key]['active'] = array_key_exists($value['slug'], $rolePermission);
                }

                return $group;
            });

        return [
            'permission' => $permission,
            'role'       => $role,
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
                    RoleEditLayout::class,
                ],
                'Right column' => [
                        RolePermissionLayout::class,
                ],
            ]),
        ];
    }

    /**
     * @param Role    $role
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Role $role, Request $request)
    {
        $role->fill($request->get('role'));

        foreach ($request->get('permissions', []) as $key => $value) {
            $permissions[base64_decode($key)] = 1;
        }

        $role->permissions = $permissions ?? [];
        $role->save();

        Alert::info(trans('platform::systems/roles.Role was saved'));

        return redirect()->route('platform.systems.roles');
    }

    /**
     * @param Role $role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Role $role)
    {
        $role->delete();

        Alert::info(trans('platform::systems/roles.Role was removed'));

        return redirect()->route('platform.systems.roles');
    }
}
