<?php

use Illuminate\Database\Seeder;
use Orchid\Press\Models\Post;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['demo-page'];
        foreach ($pages as $page) {
            if (Post::where('type', '=', 'page')->where('slug', '=', $page)->count() == 0) {
                factory(Post::class)->create(['type' => 'page', 'slug' => $page]);
            }
        }
    }
}
