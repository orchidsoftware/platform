<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class DependentListenerTest extends TestBrowserCase
{
    /**
     * @throws \Throwable
     */
    public function testLoadData(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.dependent-listener')
                ->waitForText('Test Dependent')
                ->assertInputValue('first', 100)
                ->assertDontSee('The result of adding the first argument and the second')
                ->type('second', 200)
                ->type('first', 100) // return cursor for run event onchange
                ->waitForText('The result of adding the first argument and the second')
                ->assertSee('SUM')
                ->assertInputValue('sum', 300);
        });
    }
}
