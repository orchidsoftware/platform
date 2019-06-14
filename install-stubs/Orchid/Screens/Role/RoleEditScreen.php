<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
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
    public $name = 'Roles';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Access rights';

    /**
     * @var string
     */
    public $permission = 'platform.systems.roles';

    /**
     * @var bool
     */
    private $exist = false;

    /**
     * Query data.
     *
     * @param Role $role
     *
     * @return array
     */
    public function query(Role $role): array
    {
        $this->exist = $role->exists;

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
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::name(__('Save'))
                ->icon('icon-check')
                ->method('save'),

            Link::name(__('Remove'))
                ->icon('icon-trash')
                ->method('remove')
                ->canSee($this->exist),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            RoleEditLayout::class,
            RolePermissionLayout::class,
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

        Alert::info(__('Role was saved'));

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

        Alert::info(__('Role was removed'));

        return redirect()->route('platform.systems.roles');
    }
}
