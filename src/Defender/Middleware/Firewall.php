<?php

namespace Orchid\Defender\Middleware;

use Closure;

class Firewall
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array($request->ip(), config('defender.whitelist'))) {
            abort(503);
        }

        return $next($request);
    }
}
