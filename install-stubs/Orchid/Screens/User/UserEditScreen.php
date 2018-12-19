<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Fields\PasswordField;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserRoleLayout;

class UserEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'User';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'All registered users';

    /**
     * Query data.
     *
     * @param \Orchid\Platform\Models\User $user
     *
     * @return array
     */
    public function query(User $user): array
    {
        return [
            'user'       => $user,
            'permission' => $user->getStatusPermission(),
            'roles'      => $user->getStatusRoles(),
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

            Link::name(__('Settings'))
                ->icon('icon-open')
                ->group([
                    Link::name(__('Login as user'))
                        ->icon('icon-login')
                        ->method('switchUserStart'),

                    Link::name(__('Change Password'))
                        ->icon('icon-lock-open')
                        ->title(__('Change Password'))
                        ->modal('password'),
                ]),

            Link::name(__('Save'))
                ->icon('icon-check')
                ->method('save'),

            Link::name(__('Remove'))
                ->icon('icon-trash')
                ->method('remove'),
        ];
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function layout(): array
    {
        return [
            UserEditLayout::class,
            UserRoleLayout::class,

            Layouts::modals([
                'password' => Layouts::rows([
                    PasswordField::make('user.password')
                        ->title(__('Password'))
                        ->placeholder('********'),
                ]),
            ]),
        ];
    }

    /**
     * @param \Orchid\Platform\Models\User $user
     * @param \Illuminate\Http\Request     $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(User $user, Request $request)
    {
        $permissions = $request->get('permissions', []);
        $roles = Role::whereIn('slug', $request->get('roles', []))->get();

        foreach ($permissions as $key => $value) {
            unset($permissions[$key]);
            $permissions[base64_decode($key)] = $value;
        }

        $user
            ->fill($request->all())
            ->fill([
                'permissions' => $permissions,
            ])
            ->replaceRoles($roles)
            ->save();

        Alert::info(__('User was saved'));

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

        Alert::info(__('User was removed'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param \Orchid\Platform\Models\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchUserStart(User $user, Request $request)
    {
        if (! session()->has('original_user')) {
            session()->put('original_user', $request->user()->id);
        }
        Auth::login($user);

        return back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchUserStop()
    {
        $id = session()->pull('original_user');
        Auth::loginUsingId($id);

        return back();
    }
}
