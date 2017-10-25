<?php

namespace Orchid\Platform\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;

class RedirectIfLocked extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param array                     $guards
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($guards);

        if (session()->get(config('lockscreen.name'), false)) {
            return redirect(config('lockscreen.redirect_if_locked', '/lockscreen'));
        }

        return $next($request);
    }
}
