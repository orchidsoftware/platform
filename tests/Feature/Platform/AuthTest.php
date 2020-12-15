<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class AuthTest extends TestFeatureCase
{
    public function testRouteDashboardLogin(): void
    {
        $this->get(route('platform.login'))
            ->assertOk()
            ->assertSee('type="email"', false)
            ->assertSee('type="password"', false);
    }

    public function testRouteDashboardLoginAuth(): void
    {
        $this->actingAs($this->createAdminUser())
            ->get(route('platform.login'))
            ->assertStatus(302)
            ->assertRedirect('/home');
    }

    public function testRouteDashboardLoginAuthSuccess(): void
    {
        $this->post(route('platform.login.auth'), [
            'email' => $this->createAdminUser()->email,
            'password' => 'password',
            'remember' => 'on',
        ])
            ->assertStatus(302)
            ->assertRedirect(route(config('platform.index')))
            ->assertCookieNotExpired('lockUser');
    }

    public function testRouteDashboardLoginAuthFail(): void
    {
        $this->post(route('platform.login.auth'), [
            'email' => $this->createAdminUser()->email,
            'password' => 'Incorrect password',
        ])
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testRouteDashboardGuestLockAuth(): void
    {
        $this->call('GET', route('platform.login.lock'), $parameters = [], $cookies = [
            'lockUser' => 1,
        ])
            ->assertRedirect(route('platform.login'))
            ->assertCookieExpired('lockUser');
    }

    public function testRouteDashboardSwitchLogout(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.switch.logout'))
            ->assertRedirect(route(config('platform.index')));
    }

    public function testRouteDashboardAuthLogout(): void
    {
        $auth = $this->actingAs($this->createAdminUser());

        $auth->post(route('platform.logout'))
            ->assertRedirect('/');

        $auth->get(route('platform.index'))
            ->assertRedirect(route('platform.login'));
    }
}
