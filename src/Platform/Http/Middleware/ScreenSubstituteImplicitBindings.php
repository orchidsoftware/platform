<?php

namespace Orchid\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Screen;

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

        $method = $route->parameter('method', 'query');

        $uses = Str::of($route->action['uses'])
            ->replace('__invoke', $method)
            ->toString();

        Screen::prepareForExecuteMethod($uses);

        return $next($request);
    }
}
