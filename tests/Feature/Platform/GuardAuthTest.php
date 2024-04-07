<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class GuardAuthTest extends TestFeatureCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('platform.guard', 'admin');

        config()->set('auth.guards.admin', [
            'driver'   => 'session',
            'provider' => 'admins',
        ]);

        config()->set('auth.providers.admins', [
            'driver' => 'eloquent',
            'model'  => User::class,
        ]);
    }

    public function testRouteCustomGuardAuthSuccess(): void
    {
        $this->post(route('platform.login.auth'), [
            'email'    => $this->createAdminUser()->email,
            'password' => 'password',
            'remember' => 'on',
        ])
            ->assertStatus(302)
            ->assertRedirect(route(config('orchid.index')));
    }

    public function testFailCustomGuard(): void
    {
        $this
            ->actingAs($this->createAdminUser(), 'web')
            ->get(route('platform.index'))
            ->assertStatus(302)
            ->assertRedirect(route('platform.login'));
    }

    public function testCustomGuardShouldUse(): void
    {
        Route::middleware(config('orchid.middleware.private'))->get('custom-guard', function () {
            /** @var \Illuminate\Auth\SessionGuard $sessionGuard */
            $sessionGuard = Auth::guard();

            return $sessionGuard->getName();
        })->name('test.custom-guard');

        $this
            ->actingAs($this->createAdminUser(), 'admin')
            ->get(route('test.custom-guard'))
            ->assertSee('login_admin');
    }
}
