<?php

namespace Orchid\Platform\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Platform\Tests\TestBrowserCase;

class AuthTest extends TestBrowserCase
{
    /** @test */
    public function can_use_dusk()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('dashboard.login')
                ->assertSee('Login');
        });
    }
}
