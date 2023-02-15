<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class LoginTest extends TestBrowserCase
{
    public function testLogout(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();

            // login
            $browser
                ->visitRoute('platform.login')
                ->waitForText('Sign in to your account')

                // invalid login
                ->type('email', 'admin@admin.com')
                ->type('password', 'error')
                ->press('Login')
                ->waitForText('The details you entered did not match our records. Please double-check and try again.')
                ->assertSee('The details you entered did not match our records. Please double-check and try again.')

                // valid login
                ->type('email', $user->email)
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
                ->visitRoute('platform.profile')
                ->clickLink($user->name)
                ->waitForText('Sign out', 5)
                ->press('Sign out')
                ->waitForText('404', 5);

            //Redirect to login
            $browser
                ->visitRoute('platform.main')
                ->waitForLocation('/dashboard/login')
                ->assertSee('Sign in to your account');
        });
    }
}
