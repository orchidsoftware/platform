<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Orchid\Tests\TestFeatureCase;

class ScreenUnaccessedTest extends TestFeatureCase
{
    public function test_redirect_unaccessed(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->get(route('test.unaccessed'))
            ->assertRedirect('/other-screen');
    }
}
