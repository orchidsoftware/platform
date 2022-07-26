<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser\Fields;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;
use Throwable;

class SelectTest extends TestBrowserCase
{
    /**
     * @throws Throwable
     */
    public function testSubmittedData(): void
    {
        $assert = collect([
            "choiceFromModel"                    => "1",
            "choiceEmptyOptions"                 => null,
            "choiceOptions"                      => "1",
            "choiceAssociativeOptions"           => "red",
            "choiceOptionsWithEmpty"             => null,
            "choiceOptionsWithEmptyName"         => null,
            "relationFromModel"                  => null,
            "relationFromModelMultipleWithValue" => ["1"],
        ])->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $this->browse(function (Browser $browser) use ($assert) {
            $browser
                ->loginAs($this->createAdminUser())
                ->visitRoute('test.base-select-screen')
                ->press('Submit')
                ->assertSourceHas($assert);
        });
    }
}
