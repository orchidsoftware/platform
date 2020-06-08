<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Access\UserSwitch;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;

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
    public $description = 'Details such as name, email and password';

    /**
     * @var string
     */
    public $permission = 'platform.systems.users';

    /**
     * @var User
     */
    protected $user;

    /**
     * Query data.
     *
     * @param User $user
     *
     * @return array
     */
    public function query(User $user): array
    {
        $user->load(['roles']);

        $this->user = $user;

        return [
            'user'       => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [

            DropDown::make(__('Settings'))
                ->icon('icon-open')
                ->list([
                    Button::make(__('Login as user'))
                        ->icon('icon-login')
                        ->method('loginAs'),

                    ModalToggle::make(__('Change Password'))
                        ->icon('icon-lock-open')
                        ->method('changePassword')
                        ->modal('password'),

                    ModalToggle::make(__('Two Factor Authentication'))
                        ->icon('icon-screen-smartphone')
                        ->method('enableTwoFactorAuth')
                        ->modal('twoFactorEnabled')
                        ->canSee(! $this->user->uses_two_factor_auth)
                        ->asyncParameters([
                            'users' => $this->user->id,
                        ]),

                    ModalToggle::make(__('Two Factor Authentication'))
                        ->icon('icon-screen-smartphone')
                        ->method('disableTwoFactorAuth')
                        ->canSee($this->user->uses_two_factor_auth)
                        ->modal('twoFactorDisabled')
                        ->asyncParameters([
                            'users' => $this->user->id,
                        ]),

                ]),

            Button::make(__('Save'))
                ->icon('icon-check')
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('icon-trash')
                ->confirm('Are you sure you want to delete the user?')
                ->method('remove'),
        ];
    }

    /**
     * @throws \Throwable
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            UserEditLayout::class,
            RolePermissionLayout::class,

            Layout::modal('password', [
                Layout::rows([
                    Password::make('password')
                        ->placeholder(__('Enter your password'))
                        ->required()
                        ->title(__('Password')),
                ]),
            ])->title(__('Change Password')),

            Layout::modal('twoFactorEnabled', [Layout::view('platform::auth.settings.enable-two-factor-auth')])
                ->title(__('Two Factor Authentication'))
                ->applyButton(__('Enable two-factor authentication'))
                ->async('asyncGenerateTwoFactorCode'),

            Layout::modal('twoFactorDisabled', [Layout::view('platform::auth.settings.disable-two-factor-auth')])
                ->title(__('Are you sure you wish to disable two-factor authentication?'))
                ->applyButton(__('Disable two-factor authentication')),
        ];
    }

    /**
     * @param User      $user
     * @param Dashboard $dashboard
     *
     * @return array
     */
    public function asyncGenerateTwoFactorCode(User $user, Dashboard $dashboard): array
    {
        $generator = $dashboard->getTwoFactor();

        return [
            'secret' => $generator->getSecretKey(),
            'image'  => $generator->getQrCode(config('app.name'), $user->email),
        ];
    }

    /**
     * Enable two-factor authentication for the user.
     *
     * @param User      $user
     * @param Request   $request
     * @param Dashboard $dashboard
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enableTwoFactorAuth(User $user, Request $request, Dashboard $dashboard)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $generator = $dashboard->getTwoFactor();
        $secret = $request->get('secret');
        $generator->setSecretKey($secret);

        if (! $generator->verify($request->get('token'))) {
            return back()->withErrors([
                'token' => __('This value is not valid'),
            ]);
        }

        $user->forceFill([
            'uses_two_factor_auth'      => true,
            'two_factor_secret_code'    => $request->get('secret'),
            'two_factor_recovery_code'  => Str::random(8),
        ])->save();

        Toast::success(__('Two-factor authentication has been enabled.'));

        Alert::view('platform::auth.settings.two-factor-generator-message', Color::SECONDARY(), [
            'code' => $user->two_factor_recovery_code,
        ]);

        return back();
    }

    /**
     * Disable two-factor authentication for the given user.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableTwoFactorAuth(User $user)
    {
        $user->forceFill([
            'uses_two_factor_auth'      => false,
            'two_factor_secret_code'    => null,
            'two_factor_recovery_code'  => null,
        ])->save();

        Toast::success(__('Two-factor authentication has been disabled.'));

        return back();
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(User $user, Request $request)
    {
        $request->validate([
            'user.email' => 'required|unique:users,email,'.$user->id,
        ]);

        $permissions = collect($request->get('permissions'))
            ->map(function ($value, $key) {
                return [base64_decode($key) => $value];
            })
            ->collapse()
            ->toArray();

        $user
            ->fill($request->get('user'))
            ->replaceRoles($request->input('user.roles'))
            ->fill([
                'permissions' => $permissions,
            ])
            ->save();

        Toast::info(__('User was saved.'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param User $user
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        $user->delete();

        Toast::info(__('User was removed'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(User $user)
    {
        UserSwitch::loginAs($user);

        return redirect()->route(config('platform.index'));
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(User $user, Request $request)
    {
        $user->password = Hash::make($request->get('password'));
        $user->save();

        Toast::info(__('User was saved.'));

        return back();
    }
}
