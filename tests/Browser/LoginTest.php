<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class LoginTest extends TestBrowserCase
{
    public function testDisplayPage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('platform.login')
                ->assertSee('Sign in to your account');
        });
    }

    public function testLogout(): void
    {
        $this->browse(function (Browser $browser) {
            // login
            $browser
                ->visitRoute('platform.login')
                ->waitForText('Sign in to your account')
                ->type('email', 'admin@admin.com')
                ->type('password', 'password')
                ->press('Login')
                ->waitForLocation('/dashboard/main')
                ->assertSee('Example screen');

            //Redirect to home
            $browser
                ->visitRoute('platform.login')
                ->waitForLocation('/home');

            //Logout
            $browser
                ->visitRoute('platform.main')
                ->clickLink('admin')
                ->assertSee('Sign out')
                ->click('@logout-button')
                ->waitForText('404');

            //Redirect to login
            $browser
                ->visitRoute('platform.main')
                ->waitForLocation('/dashboard/login')
                ->assertSee('Sign in to your account');
        });
    }

    public function testErrorLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('platform.login')
                ->type('email', 'admin@admin.com')
                ->type('password', 'error')
                ->press('Login')
                ->waitForText('The details you entered did not match our records. Please double-check and try again.')
                ->assertSee('The details you entered did not match our records. Please double-check and try again.');
        });
    }

    public function testSuccessLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('platform.login')
                ->type('email', 'admin@admin.com')
                ->type('password', 'password')
                ->press('Login')
                ->waitForLocation('/dashboard/main')
                ->assertSee('Example screen');
        });
    }
}
