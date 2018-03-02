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
     * @param User $user
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
		//  Выше неизмененнный код из AccessUserForm.php
		
		// Ниже танцы с бубном для передачи value в поля
		
		//dump($roles);
		$userpermission=$permission;
		$selroles=$roles;
		$roles=$selroles->where('active',true)->pluck('slug')->all();
		//dump($roleselect);
		$permission=[];
		foreach ($userpermission as $keyGroup => $itemGroup) {
			foreach ($itemGroup as $key => $item) {
				$permission[str_replace(".", "_", $item['slug'])]=($item['active'])?'1':null;
			}	
		}
		/*
		$permission['dashboard_pages'] =null;
		$permission['dashboard_systems_menu'] =null;
		*/
		
		//$roles->value = 'admins';
		//dump($user);		
		//dump($permission);		
		//dd($permission);
		
		
        return [
            'user'   => $user,
			'permissions' => $permission,
			'userpermission' => $userpermission,
			'roles[]'      => $roles,
			'selroles' => $selroles,
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
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
	
    public function save(User $user)
    {
        //dd($this->request);
        //dd($this->request->get('user'));
		//dd($this->request->get('permissions'));
		
		
		//$user->fill($this->request->get('user'));
		
		$user->name=$this->request->get('user')['name'];
		$user->email=$this->request->get('user')['email'];
		//$user->fill($this->request->get('roles')); 
		$user->roles($this->request->get('roles'));
		//$user->replaceRoles($this->request->get('roles'));

		foreach ($this->request->get('permissions') as $key => $item) {
			$permission[str_replace("_", ".", $key)]=$item;
		}	
		//dd($permission);
		$user->permissions=$permission; //->save();
        //dd($user);
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
