<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;
use Throwable;

class DependentListenerTest extends TestBrowserCase
{
    /**
     * @throws Throwable
     */
    public function test_load_data(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.dependent-listener')
                ->waitForText('Test Dependent')
                ->assertInputValue('first', 100)
                ->assertDontSee('The result of adding the first argument and the second')
                ->type('second', 200)
                ->click('h1') // return cursor for run event onchange
                ->waitForText('The result of adding the first argument and the second')
                ->assertSee('SUM')
                ->assertInputValue('sum', 300);
        });
    }

    public function test_load_data_from_modal(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.dependent-listener-modal')
                ->waitForText('Test Dependent in Modal')
                ->press('Open Listener Modal')
                ->waitForText('Listener in modal')
                ->assertInputValue('first', 100)
                ->assertDontSee('The result of adding the first argument and the second')
                ->type('second', 200)
                ->doubleClick() // return cursor for run event onchange
                ->waitForText('The result of adding the first argument and the second')
                ->assertSee('SUM')
                ->assertInputValue('sum', 300);
        });
    }

    public function test_load_data_from_nested_targets(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.dependent-listener-nested-targets')
                ->waitForText('Test child Dependent')
                ->assertInputValue('father[first]', 100)
                ->assertDontSee('The result of adding the first argument and the second')
                ->type('father[second]', 200)
                ->click('h1') // return cursor for run event onchange
                ->waitForText('The result of adding the first argument and the second')
                ->assertSee('SUM')
                ->assertInputValue('sum', 300);
        });
    }
}
