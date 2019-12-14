<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Auth;

use Illuminate\Contracts\View\Factory;
use Illuminate\Cookie\CookieJar;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Orchid\Access\UserSwitch;
use Orchid\Platform\Http\Controllers\Controller;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', [
                'except' => [
                    'logout',
                    'switchLogout',
                ],
            ]);
    }

    /**
     * @return Factory|View
     */
    public function showLoginForm()
    {
        return view('platform::auth.login');
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @return string
     */
    public function redirectTo()
    {
        return route(config('platform.index'));
    }

    /**
     * Get the failed login response instance.
     *
     * @throws ValidationException
     *
     * @return void
     */
    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [__('The details you entered did not match our records. Please double-check and try again.')],
        ]);
    }

    /**
     * @param \Illuminate\Cookie\CookieJar $cookieJar
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetCookieLockMe(CookieJar $cookieJar)
    {
        $lockUser = $cookieJar->forget('lockUser');

        return redirect()->route('platform.login')->withCookie($lockUser);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLogout()
    {
        UserSwitch::logout();

        return redirect()->route(config('platform.index'));
    }
}
