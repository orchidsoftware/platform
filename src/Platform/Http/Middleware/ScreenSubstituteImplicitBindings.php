<?php

namespace Orchid\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ScreenSubstituteImplicitBindings
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();

        if ($route === null) {
            return $next($request);
        }

        // Set query parameters as route parameters
        collect($request->query())->each(fn($value, string $key) => $route->setParameter($key, $value));

        $originalAction = $route->action['uses'];

        // Replace the '__invoke' method with the specified 'query' parameter
        $method = $route->parameter('method', 'query');

        $route = $route->uses(
            Str::of($originalAction)->replace('__invoke', $method)->toString()
        );

        // Substitute implicit route bindings
        Route::substituteImplicitBindings($route);

        // Reset the action to the original one
        $route->uses($originalAction);

        return $next($request);
    }
}
