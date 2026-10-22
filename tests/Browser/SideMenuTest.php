<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class SideMenuTest extends TestBrowserCase
{
    public function testResponsiveSideMenuNavigation(): void
    {
        $this->browse(function (Browser $browser) {
            $activity = '[data-side-menu-list] a[href$="/side-menu/activity"]';

            $browser
                ->loginAs($this->createAdminUser())
                ->resize(1440, 900)
                ->visitRoute('test.side-menu')
                ->assertVisible('[data-side-menu-list]')
                ->assertAttribute('[data-side-menu] [aria-current="page"]', 'aria-current', 'page')
                ->mouseover('#side-menu-demo-heading')
                ->pause(200);

            $restingBackground = $browser->script(
                "return getComputedStyle(document.querySelector('$activity')).backgroundColor;"
            )[0];

            $this->assertGreaterThanOrEqual(43, $browser->script(
                "return document.querySelector('$activity').getBoundingClientRect().height;"
            )[0]);

            $browser->mouseover($activity)->pause(400);

            $hoverBackground = $browser->script(
                "return getComputedStyle(document.querySelector('$activity')).backgroundColor;"
            )[0];

            $this->assertNotSame($restingBackground, $hoverBackground);
            $this->assertSame('rgb(255, 255, 255)', $browser->script(
                'return getComputedStyle(document.querySelector("[data-side-menu]")).backgroundColor;'
            )[0]);
            $this->assertSame('none', $browser->script(
                'return getComputedStyle(document.querySelector("[data-side-menu]")).boxShadow;'
            )[0]);
            $this->assertTrue($browser->script(<<<'JS'
                const separator = document.querySelector('[data-side-menu-list] > li:has(a[href$="/side-menu/long-label"]) + li[role="separator"]');
                const support = separator?.nextElementSibling?.querySelector('a[href$="/side-menu/support"]');

                return separator !== null
                    && support !== null
                    && getComputedStyle(separator).borderBottomWidth === '1px';
                JS)[0]);

            $browser
                ->clickLink('Recent activity')
                ->waitForLocation(route('test.side-menu.activity', absolute: false))
                ->assertSeeIn('#side-menu-demo-heading', 'Recent activity')
                ->assertAttribute('[data-side-menu] [aria-current="page"]', 'aria-current', 'page');

            $this->assertSame(1, $browser->script(
                'return document.querySelectorAll("[data-side-menu] [aria-current=page]").length;'
            )[0]);

            $browser->resize(820, 900);

            $this->assertFalse($browser->script(
                'return document.documentElement.scrollWidth > document.documentElement.clientWidth;'
            )[0]);
            $this->assertGreaterThanOrEqual(240, $browser->script(
                'return document.querySelector("[data-side-menu]").getBoundingClientRect().width;'
            )[0]);

            $browser
                ->resize(390, 844)
                ->assertVisible('[data-side-menu-toggle]')
                ->assertMissing('[data-side-menu-collapse].show');

            $this->assertFalse($browser->script(
                'return document.documentElement.scrollWidth > document.documentElement.clientWidth;'
            )[0]);

            $browser
                ->click('[data-side-menu-toggle]')
                ->waitFor('[data-side-menu-collapse].show')
                ->assertAttribute('[data-side-menu-toggle]', 'aria-expanded', 'true')
                ->click('[data-side-menu-list] [aria-controls]')
                ->waitFor('[data-side-menu] .sub-menu.show')
                ->assertSee('General')
                ->assertSee('Members and permissions');
        });
    }
}
