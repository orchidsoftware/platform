<?php

use Illuminate\Database\Seeder;

use Orchid\Platform\Core\Models\Post;
use Orchid\Platform\Core\Models\Comment;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
		factory(Post::class, 10)->create()->each(function ($p) {
            $p->comments()->saveMany(factory(Comment::class, 2)->create(['post_id'=>$p->id])
				->each(function($c){
                    $c->replies()->saveMany(factory(Comment::class, 1)->make(['post_id'=>$c->post_id,'parent_id'=>$c->id]));
				}));
		});
    }
}
