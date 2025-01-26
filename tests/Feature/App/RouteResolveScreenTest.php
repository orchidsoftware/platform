<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Models\User;
use Orchid\Tests\App\Screens\ModelRouteBindScreen;
use Orchid\Tests\App\Screens\ModelRouteParamBindScreen;
use Orchid\Tests\App\Screens\RouteResolveScreen;
use Orchid\Tests\TestFeatureCase;

class RouteResolveScreenTest extends TestFeatureCase
{
    public function test_resolve_model(): void
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

    public function test_implicit_binding(): void
    {
        Route::screen('bind/users/{user}', ModelRouteBindScreen::class)
            ->middleware(config('orchid.middleware.private'))
            ->name('bind.implicit-binding');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.implicit-binding', $user->id))
            ->assertOk()
            ->assertSee($user->id)
            ->assertSee($user->email);
    }

    public function test_implicit_binding_when_allow_null(): void
    {
        Route::screen('bind/users/{user?}', ModelRouteBindScreen::class)
            ->middleware(config('orchid.middleware.private'))
            ->name('bind.implicit-binding');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.implicit-binding'))
            ->assertOk()
            ->assertSee('User ID')
            ->assertSee('User Name');
    }

    public function test_customizing_key(): void
    {
        Route::screen('bind/users/{user:email}', ModelRouteBindScreen::class)
            ->middleware(config('orchid.middleware.private'))
            ->name('bind.customizing-key');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.customizing-key', $user->email))
            ->assertOk()
            ->assertSee($user->id)
            ->assertSee($user->email);
    }

    public function test_explicit_binding(): void
    {
        Route::model('bind', User::class);

        Route::screen('bind/users/{bind}', ModelRouteParamBindScreen::class)
            ->middleware(config('orchid.middleware.private'))
            ->name('bind.explicit-binding');

        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('bind.explicit-binding', $user->id))
            ->assertOk()
            ->assertSee($user->id)
            ->assertSee($user->email);
    }

    public function test_resolution_logic(): void
    {
        Route::bind('user', function ($value) {
            return User::where('email', $value)->firstOrFail();
        });

        Route::screen('bind/users/{user}', ModelRouteBindScreen::class)
            ->middleware(config('orchid.middleware.private'))
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
