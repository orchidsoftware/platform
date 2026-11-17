<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use DOMDocument;
use DOMXPath;
use Orchid\Tests\TestFeatureCase;

class ScreenAutoWritePropertyTest extends TestFeatureCase
{
    public function testWriteOnlyPublicProperty(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->get(route('test.write-only-public-property'))
            ->assertDontSee('protectedProperty')
            ->assertDontSee('privateProperty')
            ->assertSee('publicProperty');
    }

    public function testCellCallbackReadsPublicScreenDataOutsideTheTableTarget(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('test.write-only-public-property'))
            ->assertOk();

        $page = new DOMDocument;
        $page->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);

        self::assertSame('120', (new DOMXPath($page))->evaluate('normalize-space(//table/tbody/tr/td[1])'));
    }
}
