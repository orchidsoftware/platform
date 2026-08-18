<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Orchid\Tests\TestFeatureCase;

class AuthTest extends TestFeatureCase
{
    public function testRouteDashboardLogin(): void
    {
        DB::enableQueryLog();

        $this->get(route('orchid.login'))
            ->assertOk()
            ->assertSee('type="email"', false)
            ->assertSee('type="password"', false)
            ->assertSee('data-password-target="toggle"', false)
            ->assertSee('aria-label="Show password"', false);

        $this->assertLoginDidNotQueryUsers();
    }

    public function testRouteDashboardLoginWithEmptyLockCookie(): void
    {
        DB::enableQueryLog();

        $this->withCookie($this->lockCookieName(), '')
            ->get(route('orchid.login'))
            ->assertOk()
            ->assertSee('type="email"', false);

        $this->assertLoginDidNotQueryUsers();
    }

    public function testRouteDashboardLoginWithLockCookie(): void
    {
        $user = $this->createAdminUser();

        $this->withCookie($this->lockCookieName(), (string) $user->getKey())
            ->get(route('orchid.login'))
            ->assertOk()
            ->assertSee('value="'.$user->email.'"', false)
            ->assertSee(__('Use another account'));
    }

    public function testRouteDashboardLoginWithUnknownLockCookie(): void
    {
        $this->withCookie($this->lockCookieName(), '999999')
            ->get(route('orchid.login'))
            ->assertOk()
            ->assertSee('type="email"', false)
            ->assertDontSee(__('Use another account'));
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

    private function lockCookieName(): string
    {
        return sprintf('%s_%s', Auth::guard()->getName(), '_orchid_lock');
    }

    private function assertLoginDidNotQueryUsers(): void
    {
        $queriesUsers = collect(DB::getQueryLog())
            ->contains(static fn (array $query) => preg_match('/\bfrom\s+["`]?users["`]?/i', $query['query']) === 1);

        $this->assertFalse($queriesUsers, 'Guest login unexpectedly queried the users table.');
    }
}
