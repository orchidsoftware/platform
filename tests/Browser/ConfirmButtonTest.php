<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;
use Throwable;

class ConfirmButtonTest extends TestBrowserCase
{
    /**
     * @throws Throwable
     */
    public function testConfirmButton(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.confirm')
                ->waitForText('Test confirm')
                ->press('Submit')
                ->waitForText('Do you want to press the button?')
                ->click('#confirm-dialog button[type="submit"]')
                ->waitForText('Action completed')
                ->assertSee('Action completed');
        });
    }
}
