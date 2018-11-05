<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;

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
     * @var
     */
    protected $routeActive;

    /**
     * AccessMiddleware constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param          $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
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

        abort(404);
    }
}
