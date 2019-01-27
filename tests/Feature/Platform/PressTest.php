<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Press\Models\Page;
use Orchid\Press\Models\Post;
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
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.entities.type.page', [
                'example-page', 'example-page'
            ]));

        $response
            ->assertOk()
            ->assertSee($this->page->getContent('title'))
            ->assertSee($this->page->getContent('description'));
    }

    public function test_route_PagesUpdate()
    {
        $response = $this->actingAs($this->user)
            ->post(route('platform.entities.type.page', ['example-page','example-page','save']));

        $response->assertStatus(302);
        $this->assertContains('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);
    }

    public function test_route_PostsType()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.entities.type', 'example-post'));

        $response->assertOk();
        $this->assertContains($this->post->getContent('name'), $response->getContent());
        $this->assertNotContains($this->post->getContent('description'), $response->getContent());
    }

    public function test_route_PostsTypeEdit()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.entities.type.edit', ['example-post', $this->post->slug]));

        $response->assertOk();
        $this->assertContains($this->post->getContent('title'), $response->getContent());
        $this->assertNotContains($this->post->getContent('description'), $response->getContent());
    }

    public function test_route_PostsTypeUpdate()
    {
        $response = $this->actingAs($this->user)
            ->post(
                route('platform.entities.type.edit', ['example-post', $this->post->slug,'save']),
                [$this->post->toArray()]
            );

        $response->assertStatus(302);
        $this->assertContains('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);
    }
}
