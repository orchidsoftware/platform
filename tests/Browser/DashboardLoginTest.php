<?php

namespace Orchid\Platform\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Platform\Tests\TestBrowserCase;

class DashboardLoginTest extends TestBrowserCase
{
    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function test_is_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('dashboard.login')
                ->assertSee('Login');
        });
    }
}
