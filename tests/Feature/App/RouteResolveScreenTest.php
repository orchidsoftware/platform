<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Illuminate\Support\Facades\Route;
use Orchid\Tests\App\Screens\RouteResolveScreen;
use Orchid\Tests\TestFeatureCase;

class RouteResolveScreenTest extends TestFeatureCase
{
    public function testResolveModel(): void
    {
        Route::screen('route-resolve/{resolve}', RouteResolveScreen::class)->name('route-resolve');

        $this->post(route('route-resolve', [
            'method'  => 'resolveModel',
            'resolve' => 'test',
        ]))
            ->assertOk()
            ->assertDontSee('test')
            ->assertSee('Hello Word');
    }
}
