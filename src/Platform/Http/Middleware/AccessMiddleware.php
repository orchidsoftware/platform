<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class AccessMiddleware.
 */
class AccessMiddleware
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
     *
     * @return ResponseFactory|RedirectResponse|Response|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Carbon::setLocale(config('app.locale'));

        if ($this->auth->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }

            return redirect()->route('platform.login');
        }

        if ($this->auth->user()->hasAccess('platform.index')) {
            return $next($request);
        }

        abort(403);
    }
}
