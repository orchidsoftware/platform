<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Press\Models\Tag;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class TagsTest extends TestFeatureCase
{
    private $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_route_SystemsTagSearch()
    {
        Tag::create([
            'name' => 'Super Tag',
            'slug' => 'super-tag',
            'namespace' => 'super-tag',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.tag.search', 'super'));

        $response->assertOk();
        $this->assertStringContainsString('Super', $response->getContent());
    }
}
