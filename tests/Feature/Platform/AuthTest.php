<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class AuthTest extends TestFeatureCase
{
    public function testRouteDashboardLogin()
    {
        $response = $this->get(route('platform.login'));

        $response
            ->assertOk()
            ->assertSee('type="email"', false)
            ->assertSee('type="password"', false);
    }

    public function testRouteDashboardLoginAuth()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.login'));

        $response
            ->assertStatus(302)
            ->assertRedirect('/home');
    }

    public function testRouteDashboardLoginAuthSuccess()
    {
        $response = $this->post(route('platform.login.auth'), [
            'email'    => $this->createAdminUser()->email,
            'password' => 'secret',
            'remember' => 'on',
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route(config('platform.index')))
            ->assertCookieNotExpired('lockUser');
    }

    public function testRouteDashboardLoginAuthFail()
    {
        $response = $this->post(route('platform.login.auth'), [
            'email'    => $this->createAdminUser()->email,
            'password' => 'Incorrect password',
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testRouteDashboardPasswordRequest()
    {
        $response = $this->get(route('platform.password.request'));

        $response->assertOk()
            ->assertSee('type="email"', false)
            ->assertDontSee('type="password"', false);
    }

    public function testRouteDashboardPasswordReset()
    {
        $response = $this->get(route('platform.password.reset', '11111'));

        $response->assertOk()
            ->assertSee('type="email"', false)
            ->assertSee('type="password"', false)
            ->assertSee('"password_confirmation"', false);
    }

    public function testRouteDashboardPasswordResetAuth()
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.password.reset', '11111'));

        $response
            ->assertStatus(302)
            ->assertRedirect('/home');
    }

    public function testRouteDashboardGuestLockAuth()
    {
        $response = $this->call('GET', route('platform.login.lock'), $parameters = [], $cookies = [
            'lockUser' => 1,
        ]);

        $response
            ->assertRedirect(route('platform.login'))
            ->assertCookieExpired('lockUser');
    }
}
