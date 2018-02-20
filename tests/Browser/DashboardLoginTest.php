<?php

namespace Orchid\Platform\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Tests\TestBrowserCase;

class DashboardLoginTest extends TestBrowserCase
{
    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function test_is_login()
    {
        $user = User::where('email','admin@admin.com')->first();
    
        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->resize(1920, 1080)
                ->visitRoute('dashboard.login')
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
        $user = User::where('email','admin@admin.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->resize(1920, 1080)
                ->loginAs($user)
                ->visitRoute('dashboard.index')
                ->click('@logout-button')
                ->assertPathIsNot('/dashboard')
                ->visitRoute('dashboard.index')
                ->assertPathIs('/dashboard/login');
        });
    }
}
