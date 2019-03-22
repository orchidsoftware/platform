<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Press\Models\Tag;
use Orchid\Tests\TestFeatureCase;

class TagsTest extends TestFeatureCase
{
    public function testRouteSystemsTagSearch()
    {
        Tag::create([
            'name'      => 'Super Tag',
            'slug'      => 'super-tag',
            'namespace' => 'super-tag',
        ]);

        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.tag.search', 'super'));

        $response->assertOk();
        $this->assertStringContainsString('Super', $response->getContent());
    }
}
