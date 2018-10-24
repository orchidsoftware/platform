<?php

declare(strict_types=1);

namespace Tests\Feature\Platform;

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

    public function setUp()
    {
        parent::setUp();

        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
    }

    public function test_route_PagesShow()
    {
        $page = $this->createPage();

        $response = $this->actingAs($this->user)
            ->get(route('platform.pages.show', 'demo-page'));
        $response->assertStatus(200);
        $this->assertContains($page->getContent('title'), $response->baseResponse->content());
        $this->assertContains($page->getContent('description'), $response->baseResponse->content());
    }

    private function createPage()
    {
        $page = factory(Post::class)->create(['type' => 'page', 'slug' => 'demo-page']);

        return $page;
    }

    public function test_route_PagesUpdate()
    {
        $page = $this->createPage();

        $response = $this->actingAs($this->user)
            ->put(route('platform.pages.update', 'demo-page'));
        $response->assertStatus(302);
        //$response->assertSessionHas('level', 'success');
        $this->assertContains('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);
    }

    public function test_route_PostsType()
    {
        $post = $this->createPost();
        $response = $this->actingAs($this->user)
            ->get(route('platform.posts.type', 'demo'));

        $response->assertStatus(200);
        $this->assertContains($post->getContent('name'), $response->baseResponse->content());
        $this->assertNotContains($post->getContent('description'), $response->baseResponse->content());
    }

    private function createPost()
    {
        $post = factory(Post::class)->create();

        return $post;
    }

    public function test_route_PostsTypeEdit()
    {
        $post = $this->createPost();

        $response = $this->actingAs($this->user)
            ->get(route('platform.posts.type.edit', ['demo', $post->slug]));

        $response->assertStatus(200);
        $this->assertContains($post->getContent('title'), $response->baseResponse->content());
        //$this->assertContains($post->getContent('description'), $response->baseResponse->content());
    }

    public function test_route_PostsTypeUpdate()
    {
        $post = $this->createPost();

        $response = $this->actingAs($this->user)
            ->put(route('platform.posts.type.update', ['demo', $post->slug]));
        $response->assertStatus(302);
        //$response->assertSessionHas('level', 'success');
        $this->assertContains('success', $response->baseResponse->getRequest()->getSession()->get('flash_notification')['level']);
    }
}
