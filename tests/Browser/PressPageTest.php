<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestBrowserCase;

class PressPageTest extends TestBrowserCase
{

    /**
     * @throws \Throwable
     */
    public function test_is_page(){

        $user = User::where('email', 'admin@admin.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->resize(1920, 1080);
            $browser->loginAs($user);
            $browser->visit('/dashboard');
            $browser->clickLink('Posts');
            $browser->clickLink('Demo page');
            $browser->type('content[en][name]', 'Test');
            $browser->type('content[en][title]', 'Test');
            $browser->select('noindex', 'content[en][robot]');
            $browser->type('content[en][phone]', '(951) 305-4530');
            $browser->uncheck('content[en][free]');
            $browser->check('content[en][free]');
            $browser->type('content[en][description]', 'Azazazaza');
            //$browser->press('');
            $browser->type('content[en][link]', 'http://google.com');
            $browser->press('Generate UTM');
            $browser->press('Generate URL');
            $browser->type('content[en][open]', '2018-06-30 12:00:00');
            $browser->press('Save');
           // $browser->press('×');
            $browser->clickLink('en');
            $browser->clickLink('Россия');
            $browser->type('content[ru][name]', 'test');
            $browser->type('content[ru][title]', 'tew');
            $browser->type('content[ru][phone]', '(567) 567-_567');
            $browser->type('content[ru][description]', '567657');
            $browser->type('content[ru][link]', 'tyjtyjty');
            $browser->press('Generate UTM');
            $browser->press('Generate URL');
            $browser->type('content[ru][open]', '2018-06-20 12:00:00');
            $browser->press('Save');
            $browser->assertPathIs('/dashboard/press/page/demo-page');
        });
    }

}