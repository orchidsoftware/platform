<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class Issue2517Test extends TestBrowserCase
{
    public function test_issue2517(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();

            // check that the first screen is working
            $browser
                ->loginAs($user)
                ->visitRoute('test.items')
                ->waitForText('Items List')
                ->press('Add Item');

            $browser->whenAvailable('.modal', function (Browser $modal) {
                $modal->assertSee('Create Item')
                    ->type('item[name]', 'name 7')
                    ->press('Add Item');
            });
            $browser->waitForText('Added Item');

            // perform actions in the second
            $browser->visitRoute('test.item.addchild', 1)
                ->waitForText('Add child')
                ->type('item[name]', 'name 7')
                ->press('Save')

                ->waitForRoute('test.items')

                ->waitForText('Item with paretn_id=1 saved')

                ->press('.toast button')

                // check that the first screen is still working
                ->press('Add Item');

            $browser->whenAvailable('.modal', function (Browser $modal) {
                $modal->assertSee('Create Item')
                    ->type('item[name]', 'name 7')
                    ->press('Add Item');
            });

            $browser->waitForText('Added Item');
        });
    }
}
