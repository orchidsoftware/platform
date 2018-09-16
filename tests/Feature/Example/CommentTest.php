<?php

declare(strict_types=1);

namespace Tests\Feature\Example;

use Orchid\Platform\Models\User;
use Orchid\Press\Models\Comment;
use Orchid\Press\Models\Post;
use Orchid\Tests\TestFeatureCase;

class CommentTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= CommentTest tests\\Feature\\Example\\CommentTest --debug.
     * @var
     */
    private $user;

    public function setUp()
    {
        parent::setUp();
        //$this->withoutMiddleware();
        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
    }

    public function test_route_SystemsComments()
    {
        $post = $this->createPostWithComments();

        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.comments'));

        $response->assertStatus(200);

        $this->assertContains('icon-check', $response->baseResponse->content());
    }

    /**
     * @return Post
     */
    private function createPostWithComments()
    {
        $post = factory(Post::class)->create();

        $post->comments()->saveMany([
            factory(Comment::class)->make(['approved' => true]),
            factory(Comment::class)->make(['approved' => true]),
            factory(Comment::class)->make(['approved' => false]),
            factory(Comment::class)->make(['approved' => false]),
        ]);
        $comments = Comment::findByPostId($post->id)->each(function ($c) {
            $c->author()->associate($this->user)->save();
        });

        return $post;
    }

    public function test_route_SystemsCommentsEdit()
    {
        $post = $this->createPostWithComments();
        $comments = Comment::findByPostId($post->id);

        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.comments.edit', $comments->first()->id));
        $response->assertStatus(200);
        $this->assertContains($comments->first()->content, $response->baseResponse->content());
    }
}
