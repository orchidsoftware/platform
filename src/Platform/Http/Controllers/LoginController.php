<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Orchid\Access\Impersonation;

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

    /**
     * @var Guard|\Illuminate\Auth\SessionGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     */
    public function __construct(Auth $auth)
    {
        $this->guard = $auth->guard(config('platform.guard'));

        $this->middleware('guest', [
            'except' => [
                'logout',
                'switchLogout',
            ],
        ]);
    }

    /**
     * Handle a login request to the application.
     *
     *
     * @throws ValidationException
     *
     * @return JsonResponse|RedirectResponse
     */
    public function login(Request $request, CookieJar $cookieJar)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $auth = $this->guard->attempt(
            $request->only(['email', 'password']),
            $request->boolean('remember')
        );

        if (! $auth) {
            throw ValidationException::withMessages([
                'email' => __('The details you entered did not match our records. Please double-check and try again.'),
            ]);
        }

        if ($request->boolean('remember')) {
            $user = $cookieJar->forever($this->nameForLock(), $this->guard->id());
            $cookieJar->queue($user);
        }

        return $this->sendLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended(route(config('platform.index')));
    }

    /**
     * @param Guard $guard
     *
     * @return Factory|View
     */
    public function showLoginForm(Request $request)
    {
        $user = $request->cookie($this->nameForLock());

        /** @var EloquentUserProvider $provider */
        $provider = $this->guard->getProvider();

        $model = $provider->createModel()->find($user);

        return view('platform::auth.login', [
            'isLockUser' => optional($model)->exists ?? false,
            'lockUser'   => $model,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function resetCookieLockMe(CookieJar $cookieJar)
    {
        $lockUser = $cookieJar->forget($this->nameForLock());

        return redirect()->route('platform.login')->withCookie($lockUser);
    }

    /**
     * @return RedirectResponse
     */
    public function switchLogout()
    {
        Impersonation::logout();

        return redirect()->route(config('platform.index'));
    }

    /**
     * Log the user out of the application.
     *
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    private function nameForLock(): string
    {
        return sprintf('%s_%s', $this->guard->getName(), '_orchid_lock');
    }
}
