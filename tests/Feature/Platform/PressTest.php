<?php

declare(strict_types=1);

namespace Tests\Feature\Platform;

use Orchid\Press\Models\Page;
use Orchid\Press\Models\Post;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class PressTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= PressTest tests\\Feature\\Platform\\PressTest --debug.
     * @var
     */
    private $user;

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Post
     */
    private $post;

    public function setUp()
    {
        parent::setUp();

        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
        $this->page = factory(Page::class)->create();
        $this->post = factory(Post::class)->create();
    }

    public function test_route_PagesShow()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.pages.show', 'example-page'));

        $response->assertStatus(200);
        $this->assertContains($this->page->getContent('title'), $response->getContent());
        $this->assertContains($this->page->getContent('description'), $response->getContent());
    }

    public function test_route_PagesUpdate()
    {
        $response = $this->actingAs($this->user)
            ->put(route('platform.pages.update', 'example-page'));

        $response->assertStatus(302);
        $this->assertContains('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);
    }

    public function test_route_PostsType()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.posts.type', 'example-post'));

        $response->assertStatus(200);
        $this->assertContains($this->post->getContent('name'), $response->getContent());
        $this->assertNotContains($this->post->getContent('description'), $response->getContent());
    }

    public function test_route_PostsTypeEdit()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.posts.type.edit', ['example-post', $this->post->slug]));

        $response->assertStatus(200);
        $this->assertContains($this->post->getContent('title'), $response->getContent());
        $this->assertContains($this->post->getContent('description'), $response->getContent());
    }

    public function test_route_PostsTypeUpdate()
    {
        $response = $this->actingAs($this->user)
            ->put(route('platform.posts.type.update', ['example-post', $this->post->slug]));

        $response->assertStatus(302);
        $this->assertContains('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);
    }
}
