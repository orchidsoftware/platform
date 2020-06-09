<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Access\TwoFactorEngine;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Dashboard;
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

    public function testRouteDashboardTwoFactorAuthRedirect(): void
    {
        Dashboard::useTwoFactorAuth();

        $password = 'test';

        $user = factory(User::class)->create([
            'password'                 => Hash::make($password),
            'uses_two_factor_auth'     => true,
            'two_factor_secret_code'   => 'WSI7ZQUZDPZQZ3EC',
            'two_factor_recovery_code' => 'TAOrwweK',
        ]);

        $this->call('POST', route('platform.login.auth'), [
            'email'    => $user->email,
            'password' => $password,
        ])
            ->assertRedirect(route('platform.login.token'));
    }

    public function testRouteDashboardTwoFactorUnAuthRedirect(): void
    {
        $this->call('GET', route('platform.login.token'))
            ->assertRedirect(route('platform.login'));
    }

    public function testRouteDashboardTwoFactorAuthTimeCode(): void
    {
        Dashboard::useTwoFactorAuth();

        $user = factory(User::class)->create([
            'uses_two_factor_auth'     => true,
            'two_factor_secret_code'   => 'WSI7ZQUZDPZQZ3EC',
            'two_factor_recovery_code' => 'TAOrwweK',
        ]);

        /** @var TwoFactorEngine $generator */
        $generator = Dashboard::getTwoFactor();
        $generator->setSecretKey($user->two_factor_secret_code);

        $this->session([
            'orchid:auth:id' => $user->getKey(),
        ])
            ->call('POST', route('platform.login.token.auth'), [
                'token' => $generator->currentCode(),
            ])
            ->assertRedirect(route(config('platform.index')));
    }

    public function testRouteDashboardTwoFactorAuthRecoveryCode(): void
    {
        Dashboard::useTwoFactorAuth();

        $user = factory(User::class)->create([
            'uses_two_factor_auth'     => true,
            'two_factor_secret_code'   => 'WSI7ZQUZDPZQZ3EC',
            'two_factor_recovery_code' => 'TAOrwweK',
        ]);

        /** @var TwoFactorEngine $generator */
        $generator = Dashboard::getTwoFactor();
        $generator->setSecretKey($user->two_factor_secret_code);

        /* Recovery code */
        $this->session([
            'orchid:auth:id' => $user->getKey(),
        ])
            ->call('POST', route('platform.login.token.auth'), [
                'token' => $user->two_factor_recovery_code,
            ])
            ->assertRedirect(route(config('platform.index')));
    }

    public function testRouteDashboardTwoFactorAuthRandomCode(): void
    {
        Dashboard::useTwoFactorAuth();

        $user = factory(User::class)->create([
            'uses_two_factor_auth'     => true,
            'two_factor_secret_code'   => 'WSI7ZQUZDPZQZ3EC',
            'two_factor_recovery_code' => 'TAOrwweK',
        ]);

        /** @var TwoFactorEngine $generator */
        $generator = Dashboard::getTwoFactor();
        $generator->setSecretKey($user->two_factor_secret_code);

        $this->session([
            'orchid:auth:id' => $user->getKey(),
        ])
            ->call('POST', route('platform.login.token.auth'), [
                'token' => Str::random(),
            ])
            ->assertRedirect(route('platform.login.token.auth'));
    }
}
