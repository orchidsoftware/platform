<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;

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

    /** @noinspection PhpInconsistentReturnPointsInspection */

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
            } else {
                return redirect()->guest('/dashboard/login');
            }
        }

        if ($this->auth->user()->hasAccess('dashboard.index')) {
            return $next($request);
        }

        abort(404);
    }
}
