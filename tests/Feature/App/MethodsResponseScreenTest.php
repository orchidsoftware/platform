<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Illuminate\Testing\TestResponse;
use Orchid\Tests\TestFeatureCase;
use Symfony\Component\HttpFoundation\Response;

class MethodsResponseScreenTest extends TestFeatureCase
{
    public function testRedirect(): void
    {
        $this->callMethod('redirect')
            ->assertRedirect('#');
    }

    public function testResponse(): void
    {
        $this->callMethod('response')
            ->assertOk()
            ->assertSeeText('content');
    }

    public function testEmpty(): void
    {
        $this->callMethod('empty')
            ->assertRedirect(back()->getTargetUrl());
    }

    /**
     * @return TestResponse<Response>
     */
    private function callMethod(string $method): TestResponse
    {
        return $this
            ->actingAs($this->createAdminUser())
            ->post(route('test.methods-response', [$method]));
    }
}
