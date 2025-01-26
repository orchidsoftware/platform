<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Platform\Http\Middleware\Turbo;
use Orchid\Tests\TestUnitCase;

class TurboTest extends TestUnitCase
{
    public function test_doesnt_change_response_when_not_turbo_visit(): void
    {
        $request = Request::create('/source');
        $request->headers->add([
            'Accept' => 'text/html;',
        ]);
        $response = new RedirectResponse('/destination');
        $next = fn () => $response;

        $result = (new Turbo)->handle($request, $next);

        $this->assertEquals($response->getTargetUrl(), $result->getTargetUrl());
        $this->assertEquals(302, $result->getStatusCode());
    }

    public function test_handles_redirect_responses()
    {
        $request = Request::create('/source');
        $request->headers->add([
            'Accept' => sprintf('%s, text/html, application/xhtml+xml', Turbo::TURBO_STREAM_FORMAT),
        ]);
        $response = new RedirectResponse('/destination');
        $next = fn () => $response;

        $result = (new Turbo)->handle($request, $next);

        $this->assertEquals($response->getTargetUrl(), $result->getTargetUrl());
        $this->assertEquals(303, $result->getStatusCode());
    }
}
