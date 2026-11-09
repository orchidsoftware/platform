<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class ItemAddChildScreenFlowTest extends TestFeatureCase
{
    public function testItemAddChildScreenFlow(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->get(route('test.items'))
            ->assertSuccessful()
            ->assertSeeHtml('/dashboard/items/create"');

        $this->get(route('test.item.addchild', 1))
            ->assertSuccessful();
        $this->followingRedirects()
            ->post(route('test.item.addchild', ['parentId' => 1, 'method' => 'addChild']), ['item' => ['name' => 'name 7']])
            ->assertSuccessful() // странно, в живую там 302

            ->assertSee('Item with paretn_id=1 saved')
            ->assertSeeHtml('/dashboard/items/create"')
            ->assertDontSeeHtml('/dashboard/item/1/addChild/create"')
            ->assertDontSeeText('/dashboard/item/1/addChild/create"', false);
    }
}
