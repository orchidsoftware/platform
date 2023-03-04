<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class Turbo.
 *
 * @see https://turbo.hotwire.dev
 */
class Turbo
{
    /**
     * Sending the header Content-Type: text/vnd.turbo-stream.html
     * followed by one or more <turbo-stream> elements in the response body.
     * This lets you update multiple parts of the page without navigating
     *
     * @see https://turbo.hotwire.dev/handbook/streams
     */
    public const TURBO_STREAM_FORMAT = 'text/vnd.turbo-stream.html';

    /**
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Fallback header if dd/die/etc. functions are encountered during code execution
        if ($this->turboVisit($request) && ! headers_sent()) {
            header($request->getProtocolVersion().' 303 See Other', true, 303);
        }

        $response = $next($request);

        if (! $this->turboVisit($request)) {
            return $response;
        }

        if (! $response instanceof RedirectResponse) {
            return $response;
        }

        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        // Turbo expects a 303 redirect. We are also changing the default behavior of Laravel's failed
        // validation redirection to send the user to a page where the form of the current resource
        // is rendered (instead of just "back"), since Frames could have been used in many pages.

        return $response
            ->setStatusCode(303)
            ->setTargetUrl($response->getTargetUrl());
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    private function turboVisit($request)
    {
        return Str::contains($request->header('Accept', ''), self::TURBO_STREAM_FORMAT);
    }
}
