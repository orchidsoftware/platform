<?php

namespace Orchid\Platform\Http\Middleware;

use Closure;

class RedirectInstall
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
        if (!$this->alreadyInstalled()) {
            if (!str_contains($request->getRequestUri(), 'install')) {
                return response()->redirectToRoute('install::welcome');
            }
        }

        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {
        return config('platform.install');
    }
}
