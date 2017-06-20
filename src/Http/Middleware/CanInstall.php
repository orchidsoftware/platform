<?php

namespace Orchid\Http\Middleware;

use Closure;

class CanInstall
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
        if ($this->alreadyInstalled()) {
            abort(404);
        }

        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled(): bool
    {
        return config('content.install');
    }
}
