<?php

namespace Orchid\Platform\Http\Screens\User;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Screen\Layouts;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;


use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Core\Models\Role;

use Orchid\Platform\Http\Layouts\User\UserEditLayout;
use Orchid\Platform\Http\Layouts\User\UserRoleLayout;

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
     * @param Master $master
     *
     * @return array
     */
    public function query($user = null) : array
    {
		$user = is_null($user) ? new User() : $user;
		
		if (! is_null($user)) {
            $rolePermission = $user->permissions ?: [];
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
        } else {
            $permission = Dashboard::getPermission();
            $roles = Role::all();
        }
		
		
		$roleselect=collect([
			'value' => 'admins',
			]);
		
		//$roles->value = 'admins';
		//dump($roles);		
		//dd($permission);
		
		
        return [
            'user'   => $user,
			'permission' => $permission,
			'roles'      => $roles,
			'roleselect' => $roleselect,
        ];

		}

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar() : array
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
	 
    public function layout() : array
    {
        return [
            Layouts::tabs([
                trans('dashboard::systems/users.tabs.information') => [
					UserEditLayout::class
                ],
                trans('dashboard::systems/users.tabs.permission') => [
                    UserRoleLayout::class
                ],
            ]),
		
        ];
    }

    /**
     * @param Master $master
     *
     * @return \Illuminate\Http\RedirectResponse
     */
	 /*
    public function save(Turbase $turbase)
    {
        //dd($this->request->get('turbase'));
		//$turbase = is_null($turbase) ? new Turbase() : $turbase;
        //dump($request);
        //dd($turbase);
		$turbase->fill($this->request->get('turbase')); //->save();
		//dd($turbase->slug);
		$turbase->slug = is_null($turbase->slug) ? Str::slug($turbase->name) : $turbase->slug;
		$turbase->user_id = is_null($turbase->user_id) ? Auth::user()->id : $turbase->user_id;
		//dd(Auth::user()->id);
		$turbase->save();
        Alert::info('Turbase was saved');

        return redirect()->route('dashboard.turbase.turbases');
    }*/

    /**
     * @param Master $master
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
	 /*
    public function remove(Turbase $turbase)
    {
        $turbase->delete();
        Alert::info('Turbase was removed');

        return redirect()->route('dashboard.turbase.turbases');
    }*/

}
