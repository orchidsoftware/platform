<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Orchid\Press\Models\Post;

trait Actions
{

    /**
     * @param \Orchid\Press\Models\Post $post
     *
     * @return \Orchid\Press\Models\Post
     */
    public function create(Post $post)
    {
        return $post;
    }

    /**
     * @param \Orchid\Press\Models\Post $post
     */
    public function save(Post $post)
    {
        $post->save();
    }

    /**
     * @param \Orchid\Press\Models\Post $post
     *
     * @throws \Exception
     */
    public function delete(Post $post)
    {
        $post->delete();
    }

}
