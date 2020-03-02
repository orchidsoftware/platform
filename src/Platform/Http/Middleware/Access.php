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

/**
 * Class Access.
 */
class Access
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * AccessMiddleware constructor.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

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

        if ($this->auth->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }

            return redirect()->guest(route('platform.login'));
        }

        if ($this->auth->user()->hasAccess($permission)) {
            return $next($request);
        }

        abort(403);
    }
}
