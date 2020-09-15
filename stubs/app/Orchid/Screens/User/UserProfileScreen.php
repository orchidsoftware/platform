<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Orchid\Layouts\User\UserEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserProfileScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Profile';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Basic information';

    /**
     * @var User
     */
    protected $user;

    /**
     * Query data.
     *
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): array
    {
        $this->user = $request->user();

        return [
            'user' => $this->user,
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
                ->icon('open')
                ->list([
                    ModalToggle::make(__('Change Password'))
                        ->icon('lock-open')
                        ->method('changePassword')
                        ->modal('password'),

                    ModalToggle::make(__('Two Factor Authentication'))
                        ->icon('screen-smartphone')
                        ->method('enableTwoFactorAuth')
                        ->modal('twoFactorEnabled')
                        ->canSee(! $this->user->uses_two_factor_auth)
                        ->asyncParameters([
                            'users' => $this->user->id,
                        ]),

                    ModalToggle::make(__('Two Factor Authentication'))
                        ->icon('screen-smartphone')
                        ->method('disableTwoFactorAuth')
                        ->canSee($this->user->uses_two_factor_auth)
                        ->modal('twoFactorDisabled')
                        ->asyncParameters([
                            'users' => $this->user->id,
                        ]),

                ]),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            UserEditLayout::class,

            Layout::modal('password', [
                Layout::rows([
                    Password::make('old_password')
                        ->placeholder(__('Enter the current password'))
                        ->required()
                        ->title(__('Old password'))
                        ->help('This is your password set at the moment.'),

                    Password::make('password')
                        ->placeholder(__('Enter the password to be set'))
                        ->required()
                        ->title(__('New password')),

                    Password::make('password_confirmation')
                        ->placeholder(__('Enter the password to be set'))
                        ->required()
                        ->title(__('Confirm new password'))
                        ->help('A good password is at least 15 characters or at least 8 characters long, including a number and a lowercase letter.'),
                ]),
            ])
                ->title(__('Change Password'))
                ->applyButton('Update password'),

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
     * @param Request   $request
     * @param Dashboard $dashboard
     *
     * @return array
     */
    public function asyncGenerateTwoFactorCode(Request $request, Dashboard $dashboard): array
    {
        $generator = $dashboard->getTwoFactor();

        return [
            'secret' => $generator->getSecretKey(),
            'image'  => $generator->getQrCode(config('app.name'), $request->user()->email),
        ];
    }

    /**
     * Enable two-factor authentication for the user.
     *
     * @param Request   $request
     * @param Dashboard $dashboard
     */
    public function enableTwoFactorAuth(Request $request, Dashboard $dashboard)
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

        $request->user()
            ->forceFill([
                'uses_two_factor_auth'     => true,
                'two_factor_secret_code'   => $request->get('secret'),
                'two_factor_recovery_code' => Str::random(8),
            ])
            ->save();

        Toast::success(__('Two-factor authentication has been enabled.'));

        Alert::view('platform::auth.settings.two-factor-generator-message', Color::SECONDARY(), [
            'code' => $request->user()->two_factor_recovery_code,
        ]);
    }

    /**
     * Disable two-factor authentication for the given user.
     *
     * @param Request $request
     */
    public function disableTwoFactorAuth(Request $request)
    {
        $request->user()->forceFill([
            'uses_two_factor_auth'      => false,
            'two_factor_secret_code'    => null,
            'two_factor_recovery_code'  => null,
        ])->save();

        Toast::success(__('Two-factor authentication has been disabled.'));
    }

    /**
     * @param Request $request
     */
    public function save(Request $request)
    {
        $request->validate([
            'user.name'  => 'required|string',
            'user.email' => 'required|unique:users,email,'.$request->user()->id,
        ]);

        $request->user()
            ->fill($request->get('user'))
            ->save();

        Toast::info(__('Profile updated.'));
    }

    /**
     * @param Request $request
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|password:web',
            'password'     => 'required|confirmed',
        ]);

        tap($request->user(), function ($user) use ($request) {
            $user->password = Hash::make($request->get('password'));
        })->save();

        Toast::info(__('Password changed.'));
    }
}
