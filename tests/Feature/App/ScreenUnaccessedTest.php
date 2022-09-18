<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Orchid\Tests\TestFeatureCase;

class ScreenUnaccessedTest extends TestFeatureCase
{
    public function testRedirectUnaccessed(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->get(route('test.unaccessed'))
            ->assertRedirect('/other-screen');
    }
}
