<?php

namespace Orchid\Platform\Http\Middleware;

use Illuminate\Http\Request;
use Orchid\Icons\IconFinder;

class BladeIcons
{
    /**
     * Use the supplied icon finder when processing rendered content.
     *
     * @param IconFinder $iconFinder
     */
    public function __construct(
        private IconFinder $iconFinder
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next): mixed
    {
        $this->iconFinder->setSize('1.25em', '1.25em');

        return $next($request);
    }
}
