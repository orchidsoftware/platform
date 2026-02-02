<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Auth;
use Orchid\Tests\TestFeatureCase;

class AuthTest extends TestFeatureCase
{
    public function testRouteDashboardLogin(): void
    {
        $this->get(route('orchid.login'))
            ->assertOk()
            ->assertSee('type="email"', false)
            ->assertSee('type="password"', false);
    }

    public function testRouteDashboardLoginAuth(): void
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('orchid.login'))
            ->assertStatus(302);

        $this->assertTrue(
            // Home for Laravel 10.x and earlier
            // '/' for Laravel 11.x and later
            $response->isRedirect(url('/home'))
                || $response->isRedirect(url('/'))
                || $response->isRedirect(route(config('orchid.index')))
        );
    }

    public function testRouteDashboardLoginAuthSuccess(): void
    {
        $this->post(route('orchid.login.auth'), [
            'email'    => $this->createAdminUser()->email,
            'password' => 'password',
            'remember' => 'on',
        ])
            ->assertStatus(302)
            ->assertRedirect(route(config('orchid.index')))
            ->assertCookieNotExpired(sprintf('%s_%s', Auth::guard()->getName(), '_orchid_lock'));
    }

    public function testRouteDashboardLoginAuthFail(): void
    {
        $this->post(route('orchid.login.auth'), [
            'email'    => $this->createAdminUser()->email,
            'password' => 'Incorrect password',
        ])
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testRouteDashboardGuestLockAuth(): void
    {
        $this->call('GET', route('orchid.login.lock'), $parameters = [], $cookies = [
            'lockUser' => 1,
        ])
            ->assertRedirect(route('orchid.login'))
            ->assertCookieExpired(sprintf('%s_%s', Auth::guard()->getName(), '_orchid_lock'));
    }

    public function testRouteDashboardSwitchLogout(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.switch.logout'))
            ->assertRedirect(route(config('orchid.index')));
    }

    public function testRouteDashboardAuthLogout(): void
    {
        $auth = $this->actingAs($this->createAdminUser());

        $auth->post(route('orchid.logout'))
            ->assertRedirect('/');

        $auth->get(route('orchid.index'))
            ->assertRedirect(route('orchid.login'));
    }
}
