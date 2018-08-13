<?php

namespace Orchid\Database\Seeds;

use Orchid\Press\Models\Post;
use Illuminate\Database\Seeder;
use Orchid\Press\Models\Comment;
use Orchid\Attachment\Models\Attachmentable;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class, 20)->create()->each(function ($p) {
            $p->comments()->saveMany(factory(Comment::class, 2)->create(['post_id' => $p->id])
                ->each(function ($c) {
                    $c->replies()->saveMany(factory(Comment::class, 1)->make(['post_id' => $c->post_id, 'parent_id' => $c->id]));
                }));
            factory(Attachmentable::class, 4)->create(['attachmentable_id' => $p->id]);
        });
    }
}
