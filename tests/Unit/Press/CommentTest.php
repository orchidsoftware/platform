<?php

namespace Orchid\Tests\Unit\Press;

use Orchid\Press\Models\Post;
use Orchid\Tests\TestUnitCase;
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
        $this->assertInternalType('integer', $comment->id);
    }

    /**
     * @test
     */
    public function it_is_approved()
    {
        $comment = factory(Comment::class)->create([
            'approved' => true,
        ]);
        $this->assertInternalType('boolean', $comment->isApproved());
        $this->assertTrue($comment->isApproved());
    }

    /**
     * @test
     */
    public function it_can_query_post_by_id()
    {
        $post = $this->createPostWithComments();
        $comments = Comment::findByPostId($post->id);
        $this->assertEquals(2, $comments->count());
        $this->assertInstanceOf(Comment::class, $comments->first());
        $this->assertEquals($post->id, $comments->first()->post->id);
    }

    /**
     * @test
     */
    public function it_can_be_a_reply()
    {
        $comment = $this->createCommentWithReplies();
        $this->assertCount(3, $comment->replies);
        $this->assertInstanceOf(Comment::class, $comment->replies->first());
        $this->assertInternalType('boolean', $comment->replies->first()->isReply());
        $this->assertTrue($comment->replies->first()->isReply());
    }

    /**
     * @test
     */
    public function it_has_replies()
    {
        $comment = $this->createCommentWithReplies();
        $this->assertTrue($comment->hasReplies());
        $this->assertInternalType('boolean', $comment->hasReplies());
    }

    /**
     * @return Post
     */
    private function createPostWithComments()
    {
        $post = factory(Post::class)->create();

        $post->comments()->saveMany([
            factory(Comment::class)->make(),
            factory(Comment::class)->make(),
        ]);

        return $post;
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
}
