<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Models\User;
use Orchid\Tests\App\Screens\ModelRouteBindScreen;
use Orchid\Tests\App\Screens\RouteResolveScreen;
use Orchid\Tests\TestFeatureCase;

class RouteResolveScreenTest extends TestFeatureCase
{
    public function testResolveModel(): void
    {
        Route::screen('route-resolve/{resolve}', RouteResolveScreen::class)
            ->name('route-resolve');

        $this->post(route('route-resolve', [
            'method'  => 'resolveModel',
            'resolve' => 'test',
        ]))
            ->assertOk()
            ->assertDontSee('test')
            ->assertSee('Hello Word');
    }

    public function testImplicitBinding(): void
    {
        Route::screen('bind/users/{user}', ModelRouteBindScreen::class)
            ->middleware(config('platform.middleware.private'))
            ->name('bind.implicit-binding');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.implicit-binding', $user->id))
            ->assertOk()
            ->assertSee($user->id)
            ->assertSee($user->email);
    }

    public function testImplicitBindingWhenAllowNull(): void
    {
        Route::screen('bind/users/{user?}', ModelRouteBindScreen::class)
            ->middleware(config('platform.middleware.private'))
            ->name('bind.implicit-binding');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.implicit-binding'))
            ->assertOk()
            ->assertSee('User ID')
            ->assertSee('User Name');
    }

    public function testCustomizingKey():void
    {
        Route::screen('bind/users/{user:email}', ModelRouteBindScreen::class)
            ->middleware(config('platform.middleware.private'))
            ->name('bind.customizing-key');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.customizing-key', $user->email))
            ->assertOk()
            ->assertSee($user->id)
            ->assertSee($user->email);
    }

    public function testExplicitBinding(): void
    {
        Route::model('model', User::class);

        Route::screen('bind/users/{model}', ModelRouteBindScreen::class)
            ->middleware(config('platform.middleware.private'))
            ->name('bind.explicit-binding');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.explicit-binding', $user->id))
            ->assertOk()
            ->assertSee($user->id)
            ->assertSee($user->email);
    }

    public function testResolutionLogic(): void
    {
        Route::bind('bind', function ($value) {
            return User::where('email', $value)->firstOrFail();
        });

        Route::screen('bind/users/{bind}', ModelRouteBindScreen::class)
            ->middleware(config('platform.middleware.private'))
            ->name('bind.resolution-logic');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.resolution-logic', $user->email))
            ->assertOk()
            ->assertSee($user->id)
            ->assertSee($user->email);
    }
}
