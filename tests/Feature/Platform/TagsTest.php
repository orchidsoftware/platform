<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Press\Models\Tag;
use Orchid\Tests\TestFeatureCase;

class TagsTest extends TestFeatureCase
{

    private $user;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
    }

    /**
     *
     */
    public function test_route_SystemsTagSearch()
    {
        Tag::create([
            'name' => 'Super Tag',
            'slug' => 'super-tag',
            'namespace' => 'super-tag'
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.tag.search','super'));

        $response->assertOk();
        $this->assertContains('Super', $response->getContent());
    }

}