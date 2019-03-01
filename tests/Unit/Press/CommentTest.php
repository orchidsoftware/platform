<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Press;

use Orchid\Press\Models\Post;
use Orchid\Tests\TestUnitCase;
use Orchid\Platform\Models\User;
use Orchid\Press\Models\Comment;

class CommentTest extends TestUnitCase
{
    /**
     * @test
     */
    public function it_has_the_correct_instance()
    {
        $comment = factory(Comment::class)->create();

        $this->assertNotNull($comment);
        $this->assertInstanceOf(Comment::class, $comment);
    }

    /**
     * @test
     */
    public function its_id_is_an_integer()
    {
        $comment = factory(Comment::class)->create();
        $this->assertIsInt($comment->id);
    }

    /**
     * @test
     */
    public function it_is_approved()
    {
        $comment = factory(Comment::class)->create([
            'approved' => true,
        ]);
        $this->assertIsBool($comment->isApproved());
        $this->assertTrue($comment->isApproved());
    }

    /**
     * @test
     */
    public function it_can_query_post_by_id()
    {
        $post = $this->createPostWithComments();
        $comments = Comment::findByPostId($post->id);
        $this->assertCount(4, $comments);
        $this->assertInstanceOf(Comment::class, $comments->first());
        $this->assertEquals($post->id, $comments->first()->post->id);
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

        return $post;
    }

    /**
     * @test
     */
    public function it_is_all_approved()
    {
        $post = $this->createPostWithComments();
        $comments = Comment::Approved()->get();
        $post_comments = Post::get()->first()->comments()->Approved()->get();

        $this->assertCount(2, $comments);
        $this->assertCount(2, $post_comments);
    }

    /**
     * @test
     */
    public function it_can_be_a_reply()
    {
        $comment = $this->createCommentWithReplies();
        $this->assertCount(3, $comment->replies);
        $this->assertInstanceOf(Comment::class, $comment->replies->first());

        $this->assertIsBool($comment->replies->first()->isReply());
        $this->assertTrue($comment->replies->first()->isReply());
    }

    /**
     * @return Comment
     */
    private function createCommentWithReplies()
    {
        $comment = factory(Comment::class)->create();
        $comment->replies()->saveMany([
            factory(Comment::class)->make(),
            factory(Comment::class)->make(),
            factory(Comment::class)->make(),
        ]);

        return $comment;
    }

    /**
     * @test
     */
    public function it_has_replies()
    {
        $comment = $this->createCommentWithReplies();
        $this->assertTrue($comment->hasReplies());
        $this->assertIsBool($comment->hasReplies());
    }

    /**
     * @test
     */
    public function it_has_original()
    {
        $comment = $this->createCommentWithReplies();
        $child_comment = $comment->replies->first();
        $parent_comment = $child_comment->original()->first();

        $this->assertInstanceOf(Comment::class, $parent_comment);
        $this->assertNotEquals($comment->id, $child_comment->id);
        $this->assertEquals($comment->id, $parent_comment->id);
    }

    /**
     * @test
     */
    public function it_has_author()
    {
        $user = User::get()->first();
        $comment = factory(Comment::class)->create();
        $comment->author()->associate($user)->save();

        $this->assertInstanceOf(User::class, $comment->author);
        $this->assertEquals($user->id, $comment->author->id);
        $this->assertEquals($user->id, $comment->user_id);
    }
}
