<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\Role;

use Illuminate\Http\Request;
use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Http\Layouts\Role\RoleEditLayout;
use Orchid\Platform\Http\Layouts\Role\RolePermissionLayout;
use Orchid\Platform\Screen\Layouts;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;

class RoleEdit extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'dashboard::systems/roles.title';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'dashboard::systems/roles.description';

    /**
     * Query data
     *
     * @param int $roleSlug
     *
     * @return array
     */
    public function query($roleSlug = null): array
    {

        $role = is_null($roleSlug) ? new Role : Role::where('slug', $roleSlug)->firstOrFail();

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
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(trans('dashboard::common.commands.save'))
                ->icon('icon-check')
                ->method('save'),
            Link::name(trans('dashboard::common.commands.remove'))
                ->icon('icon-trash')
                ->method('remove'),
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
            Layouts::columns([
                'Left column'  => [
                    RolePermissionLayout::class
                ],
                'Right column' => [
                    RoleEditLayout::class
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

        Alert::info(trans('dashboard::systems/roles.Role was saved'));

        return redirect()->route('dashboard.systems.roles');
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Role $role)
    {
        $role->delete();

        Alert::info(trans('dashboard::systems/roles.Role was removed'));

        return redirect()->route('dashboard.systems.roles');
    }

}
