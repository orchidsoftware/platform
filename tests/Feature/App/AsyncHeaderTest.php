<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Orchid\Tests\TestFeatureCase;

class AsyncHeaderTest extends TestFeatureCase
{
    public function testScreenWithoutHeader(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->get(route('test.async-header-button-action'))
            ->assertSee(route('test.async-header-button-action', ['method' => 'message']));
    }

    public function testScreenAsyncHeader(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->from('http://127.0.0.1:8001/screen/async/header')
            ->get(route('test.async-header-button-action'))
            ->assertDontSee(route('test.async-header-button-action', ['method' => 'message']))
            ->assertSee('http://127.0.0.1:8001/screen/async/header/message');
    }
}
