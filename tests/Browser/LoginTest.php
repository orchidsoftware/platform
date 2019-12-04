<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class LoginTest extends TestBrowserCase
{
    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function testDisplayPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('platform.login')
                ->assertSee('Sign in to your account');
        });
    }

    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function testBasicLogin()
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

    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function testErrorLogin()
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

    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('platform.login')
                ->type('email', 'admin@admin.com')
                ->type('password', 'password')
                ->press('Login')
                ->waitForLocation('/dashboard/main')
                ->assertSee('Example screen')
                ->clickLink('admin')
                ->assertSee('Sign out')
                ->click('@logout-button')
                ->waitForLocation('/')
                ->visitRoute('platform.main')
                ->waitForLocation('/dashboard/login')
                ->assertSee('Sign in to your account');
        });
    }
}
