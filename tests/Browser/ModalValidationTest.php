<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class ModalValidationTest extends TestBrowserCase
{
    /**
     * @throws \Throwable
     */
    public function testReopenModalForValidationFailed(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.modal-validation')
                ->waitForText('Modal Validation')
                ->press('Show modal')
                ->waitForText('Validation modal message')
                ->type('message', 'Hello')
                ->press('Apply')
                ->waitForText('The message must be at least 10 characters.')
                ->assertSee('The message must be at least 10 characters.')
                ->assertInputValue('message', 'Hello')
                ->pause(1500)
                ->waitForText('Validation modal message')
                ->type('message', 'Hello World!')
                ->press('Apply')
                ->waitForText('Hello World!')
                ->assertSee('Hello World!')
                ->assertDontSee('Validation modal message');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testDoubleReopenModalForValidationFailed(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.modal-validation')
                ->waitForText('Modal Validation')
                ->press('Show modal')
                ->waitForText('Validation modal message')
                ->type('message', 'Hello')
                ->press('Apply')
                ->waitForText('The message must be at least 10 characters.')
                ->assertSee('The message must be at least 10 characters.')
                ->assertInputValue('message', 'Hello')
                ->pause(1500)
                ->waitForText('Validation modal message')
                ->type('message', 'Hello!')
                ->press('Apply')
                ->waitForText('The message must be at least 10 characters.');
        });
    }
}
