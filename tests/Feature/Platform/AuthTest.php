<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class AuthTest extends TestFeatureCase
{
    public function test_route_dashboard_login(): void
    {
        $this->get(route('platform.login'))
            ->assertOk()
            ->assertSee('type="email"', false)
            ->assertSee('type="password"', false);
    }

    public function test_route_dashboard_login_auth(): void
    {
        $this->actingAs($this->createAdminUser())
            ->get(route('platform.login'))
            ->assertStatus(302)
            ->assertRedirect('/home');
    }

    public function test_route_dashboard_login_auth_success(): void
    {
        $this->post(route('platform.login.auth'), [
            'email'    => $this->createAdminUser()->email,
            'password' => 'password',
            'remember' => 'on',
        ])
            ->assertStatus(302)
            ->assertRedirect(route(config('orchid.index')))
            ->assertCookieNotExpired('lockUser');
    }

    public function test_route_dashboard_login_auth_fail(): void
    {
        $this->post(route('platform.login.auth'), [
            'email'    => $this->createAdminUser()->email,
            'password' => 'Incorrect password',
        ])
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function test_route_dashboard_guest_lock_auth(): void
    {
        $this->call('GET', route('platform.login.lock'), $parameters = [], $cookies = [
            'lockUser' => 1,
        ])
            ->assertRedirect(route('platform.login'))
            ->assertCookieExpired('lockUser');
    }

    public function test_route_dashboard_switch_logout(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.switch.logout'))
            ->assertRedirect(route(config('orchid.index')));
    }

    public function test_route_dashboard_auth_logout(): void
    {
        $auth = $this->actingAs($this->createAdminUser());

        $auth->post(route('platform.logout'))
            ->assertRedirect('/');

        $auth->get(route('platform.index'))
            ->assertRedirect(route('platform.login'));
    }
}
