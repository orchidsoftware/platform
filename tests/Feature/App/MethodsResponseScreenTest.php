<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Illuminate\Testing\TestResponse;
use Orchid\Tests\TestFeatureCase;

class MethodsResponseScreenTest extends TestFeatureCase
{
    public function test_redirect(): void
    {
        $this->callMethod('redirect')
            ->assertRedirect('#');
    }

    public function test_response(): void
    {
        $this->callMethod('response')
            ->assertOk()
            ->assertSeeText('content');
    }

    public function test_empty(): void
    {
        $this->callMethod('empty')
            ->assertRedirect(back()->getTargetUrl());
    }

    private function callMethod(string $method): TestResponse
    {
        return $this
            ->actingAs($this->createAdminUser())
            ->post(route('test.methods-response', [$method]));
    }
}
