<?php

namespace Orchid\Database\Seeds;

use Orchid\Press\Models\Post;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['example-page'];
        foreach ($pages as $page) {
            if (Post::where('type', '=', 'page')->where('slug', '=', $page)->count() === 0) {
                factory(Post::class)->create(['type' => 'page', 'slug' => $page]);
            }
        }
    }
}
