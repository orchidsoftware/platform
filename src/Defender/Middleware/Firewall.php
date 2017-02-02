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
        $listIp = config('defender');

        if (count($listIp['whitelist']) && !in_array($request->ip(), $listIp['whitelist'])) {
            abort(503);
        }

        if (count($listIp['blacklist']) && !in_array($request->ip(), $listIp['blacklist'])) {
            abort(503);
        }

        return $next($request);
    }
}
