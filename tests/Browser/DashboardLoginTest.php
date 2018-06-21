<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestBrowserCase;

class DashboardLoginTest extends TestBrowserCase
{
    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function test_is_login_logout()
    {
        $user = User::where('email', 'admin@admin.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->resize(1920, 1080)
                ->visitRoute('platform.login')
                ->assertSee('Login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->click('@login-button')
                ->assertPathIsNot('/dashboard/login');
        });
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function test_is_logout()
    {
        $user = User::where('email', 'admin@admin.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->resize(1920, 1080)
                ->loginAs($user)
                ->visitRoute('platform.index')
                ->click('@logout-button')
                ->assertPathIsNot('/dashboard')
                ->visitRoute('platform.index')
                ->assertPathIs('/dashboard/login');
        });
    }
}
