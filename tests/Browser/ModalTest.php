<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class ModalTest extends TestBrowserCase
{
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
                ->waitForText('The message field must be at least 10 characters.', 30)
                ->assertSee('The message field must be at least 10 characters.')
                ->assertInputValue('message', 'Hello')
                ->waitForText('Validation modal message', 2500)
                ->type('message', 'Hello World!')
                ->press('Apply')
                ->waitForText('Hello World!')
                ->assertSee('Hello World!')
                ->assertDontSee('Validation modal message');
        });
    }

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
                ->waitForText('The message field must be at least 10 characters.', 30)
                ->assertSee('The message field must be at least 10 characters.')
                ->assertInputValue('message', 'Hello')
                ->waitForText('Validation modal message', 2500)
                ->type('message', 'Hello!')
                ->press('Apply')
                ->waitForText('The message field must be at least 10 characters.');
        });
    }

    public function testAutoOpenModal(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.modal-open')
                ->waitForText('Open modal message')
                ->assertSee('Messages to display');
        });
    }
}
