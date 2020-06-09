<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Cookie\CookieJar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Orchid\Access\UserSwitch;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Platform\Models\User;

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
     * @param CookieJar $cookieJar
     *
     * @return RedirectResponse
     */
    public function resetCookieLockMe(CookieJar $cookieJar)
    {
        $lockUser = $cookieJar->forget('lockUser');

        return redirect()->route('platform.login')->withCookie($lockUser);
    }

    /**
     * @return RedirectResponse
     */
    public function switchLogout()
    {
        UserSwitch::logout();

        return redirect()->route(config('platform.index'));
    }

    /**
     * Handle a successful authentication attempt.
     *
     * @param Request               $request
     * @param Authenticatable|Model $user
     *
     * @return RedirectResponse
     */
    public function authenticated(Request $request, Authenticatable $user)
    {
        if (Dashboard::usesTwoFactorAuth() && $user->uses_two_factor_auth) {
            return $this->redirectForTwoFactorAuth($request, $user);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Redirect the user for two-factor authentication.
     *
     * @param Request $request
     * @param Model   $user
     *
     * @return RedirectResponse
     */
    protected function redirectForTwoFactorAuth(Request $request, Model $user)
    {
        Auth::logout();

        // Before we redirect the user to the two-factor token verification screen we will
        // store this user's ID and "remember me" choice in the session so that we will
        // be able to get it back out and log in the correct user after verification.
        $request->session()->put([
            'orchid:auth:id'       => $user->getKey(),
            'orchid:auth:remember' => $request->remember,
        ]);

        return redirect()->route('platform.login.token');
    }

    /**
     * Show the two-factor authentication token form.
     *
     * @param Request $request
     *
     * @return RedirectResponse|View
     */
    public function showTokenForm(Request $request)
    {
        return $request->session()->has('orchid:auth:id')
            ? view('platform::auth.token') : redirect()->route('platform.login');
    }

    /**
     * Verify the given authentication token.
     *
     * @param Request $request
     *
     * @throws ValidationException
     *
     * @return RedirectResponse
     */
    public function verifyToken(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        // If there is no authentication ID stored in the session, it means that the user
        // hasn't made it through the login screen so we'll just redirect them back to
        // the login view. They must have hit the route manually via a specific URL.
        if (! $request->session()->has('orchid:auth:id')) {
            return redirect()->route('platform.login');
        }

        $user = Dashboard::modelClass(User::class)->findOrFail(
            $request->session()->pull('orchid:auth:id')
        );

        $generator =  Dashboard::getTwoFactor();
        $generator->setSecretKey($user->two_factor_secret_code);

        // Next, we'll verify the actual token with our two-factor authentication service
        // to see if the token is valid. If it is, we can login the user and send them
        // to their intended location within the protected part of this application.
        if ($generator->verify($request->token) || $request->token == $user->two_factor_recovery_code) {
            Auth::login($user, $request->session()->pull(
                'orchid:auth:remember', false
            ));

            return redirect()->intended($this->redirectPath());
        }

        return $this->redirectForTwoFactorAuth($request, $user)->withErrors([
            'token' => 'This value is not valid',
        ]);
    }
}
