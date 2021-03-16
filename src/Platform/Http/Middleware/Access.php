<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/**
 * Class Access.
 */
class Access
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string  $permission
     *
     * @return ResponseFactory|RedirectResponse|Response|mixed
     */
    public function handle(Request $request, Closure $next, string $permission = 'platform.index')
    {
        Carbon::setLocale(config('app.locale'));

        if (auth()->guard(config('platform.guard'))->guest()) {
            return $this->redirectToLogin($request);
        }

        if (auth()->guard(config('platform.guard'))->user()->hasAccess($permission)) {
            return $next($request);
        }

        // The current user is already signed in.
        // It means that he does not have the privileges to view.
        abort(403);
    }

    /**
     * Redirect on the application login form.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|ResponseFactory|RedirectResponse|Response
     */
    protected function redirectToLogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        }

        if (Route::has('platform.login')) {
            return redirect()->guest(route('platform.login'));
        }

        if (Route::has('login')) {
            return redirect()->guest(route('login'));
        }

        abort(401);
    }
}
