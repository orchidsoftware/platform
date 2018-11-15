<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Orchid\Platform\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('platform::auth.login');
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function redirectTo()
    {
        return config('platform.prefix');
    }

    /**
     * Get the failed login response instance.
     *
     * @return void
     */
    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [__('The details you entered did not match our records. Please double-check and try again.')],
        ]);
    }
}
