<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class Issue2517Test extends TestFeatureCase
{
    public function test_issue2517(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->get(route('test.items'))
            ->assertSuccessful()
            ->assertSee('/dashboard/items/create"', false);

        $this->get(route('test.item.addchild', 1))
            ->assertSuccessful();
        $this->followingRedirects()
            ->post(route('test.item.addchild', ['parentId' => 1, 'method' => 'addChild']), ['item' => ['name' => 'name 7']])
            ->assertSuccessful() // странно, в живую там 302

            ->assertSee('Item with paretn_id=1 saved')
            ->assertSee('/dashboard/items/create"', false)
            ->assertDontSee('/dashboard/item/1/addChild/create"', false)
            ->assertDontSeeText('/dashboard/item/1/addChild/create"', false);
    }
}
