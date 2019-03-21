<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Press\Models\Post;
use Orchid\Platform\Models\User;
use Orchid\Press\Models\Comment;
use Orchid\Tests\TestFeatureCase;

class CommentTest extends TestFeatureCase
{

    public function testRouteSystemsComments()
    {
        $this->createPostWithComments();

        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.comments'));

        $response
            ->assertOk()
            ->assertSee('icon-check');
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

        Comment::findByPostId($post->id)->each(function ($c) {
            $c->author()->associate($this->createAdminUser())->save();
        });

        return $post;
    }

    public function testRouteSystemsCommentsEdit()
    {
        $post = $this->createPostWithComments();
        $comments = Comment::findByPostId($post->id);

        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.comments.edit', $comments->first()->id));

        $response
            ->assertOk()
            ->assertSee($comments->first()->content);
    }
}
