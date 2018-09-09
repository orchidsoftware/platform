<?php
namespace Orchid\Tests\Unit\Press;

use Orchid\Press\Models\Comment;
use Orchid\Press\Models\Post;

use Orchid\Tests\TestUnitCase;

class CommentTest extends TestUnitCase
{
    /**
     * @test
     */
    public function it_can_query_post_by_id()
    {
        $post = $this->createPostWithComments();
        $comments = Comment::findByPostId($post->ID);
        $this->assertEquals(2, $comments->count());
        $this->assertInstanceOf(Comment::class, $comments->first());
        $this->assertEquals($post->ID, $comments->first()->post->ID);
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
    

}