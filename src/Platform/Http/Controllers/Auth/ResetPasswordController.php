<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Auth;

use Illuminate\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Orchid\Platform\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param Request     $request
     * @param string|null $token
     *
     * @return Factory|Response|View
     */
    public function showResetForm(Request $request, ?string $token = null)
    {
        return view('platform::auth.passwords.reset')->with(['token' => $token, 'email' => $request->email]);
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
}
