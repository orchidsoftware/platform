<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class TurbolinksLocation.
 *
 * @see https://github.com/turbolinks/turbolinks#following-redirects
 */
class TurbolinksLocation
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        return ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse)
            ? $response
            : $response->header('Turbolinks-Location', $request->url());
    }
}
