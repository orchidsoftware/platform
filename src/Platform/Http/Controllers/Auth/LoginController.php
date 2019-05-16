<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Config\Repository;
use Illuminate\Contracts\View\Factory;
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
     * @return Factory|View
     */
    public function showLoginForm()
    {
        return view('platform::auth.login');
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @return Repository|mixed
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
