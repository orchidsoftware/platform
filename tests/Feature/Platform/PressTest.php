<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Press\Models\Page;
use Orchid\Press\Models\Post;
use Orchid\Tests\TestFeatureCase;

class PressTest extends TestFeatureCase
{
    /**
     * @var Page
     */
    private $page;

    /**
     * @var Post
     */
    private $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->page = factory(Page::class)->create();
        $this->post = factory(Post::class)->create();
    }

    public function testRoutePagesShow()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.entities.type.page', [
                'example-page', 'example-page',
            ]));

        $response
            ->assertOk()
            ->assertSee($this->page->getContent('title'))
            ->assertSee($this->page->getContent('description'));
    }

    public function testRoutePagesUpdate()
    {
        $response = $this->actingAs($this->createAdminUser())
            ->post(route('platform.entities.type.page', ['example-page', 'example-page', 'save']));

        $response->assertStatus(302);
        $this->assertStringContainsString('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);
    }

    public function testRoutePostsType()
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.entities.type', 'example-post'));

        $response->assertOk();
        $this->assertStringContainsString($this->post->getContent('name'), $response->getContent());
        $this->assertStringNotContainsString($this->post->getContent('description'), $response->getContent());
    }

    public function testRoutePostsTypeCreate()
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.entities.type.create', ['example-post']));

        $response->assertOk();
    }

    public function testRoutePostsTypeEdit()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.entities.type.edit', ['example-post', $this->post->slug]));

        $response->assertOk();
        $this->assertStringContainsString($this->post->getContent('title'), $response->getContent());
        $this->assertStringNotContainsString($this->post->getContent('description'), $response->getContent());
    }

    public function testRoutePostsTypeUpdate()
    {
        $response = $this->actingAs($this->createAdminUser())
            ->post(
                route('platform.entities.type.edit', ['example-post', $this->post->slug, 'save']),
                [$this->post->toArray()]
            );

        $response->assertStatus(302);
        $this->assertStringContainsString('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);
    }

    public function testRoutePostsTypeDelete()
    {
        $post = factory(Post::class)->create();

        $response = $this->actingAs($this->createAdminUser())
            ->post(
                route('platform.entities.type.edit', ['example-post', $post->slug, 'destroy'])
            );

        $response->assertStatus(302);
        $this->assertStringContainsString('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);

        $response = $this->actingAs($this->createAdminUser())
            ->post(
                route('platform.entities.type.edit', ['example-post', $post->slug, 'destroy'])
            );

        $response->assertStatus(404);
    }
}
