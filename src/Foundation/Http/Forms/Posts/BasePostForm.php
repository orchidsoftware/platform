<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Illuminate\Support\Facades\App;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Category;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Core\Models\Section;
use Orchid\Foundation\Core\Models\TermTaxonomy;

class BasePostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Общее';

    /**
     * Display Base Options.
     *
     * @param null      $type
     * @param Post|null $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($type = null, Post $post = null)
    {
        $currentCategory = (is_null($post)) ? [] : $post->taxonomies()->get()->pluck('taxonomy', 'id')->toArray();
        $category = Category::get();

        $category = $category->map(function ($item) use ($currentCategory) {
            if (array_key_exists($item->id, $currentCategory)) {
                $item->active = true;
            } else {
                $item->active = false;
            }

            return $item;
        });

        return view('dashboard::container.posts.modules.base', [
            'author'          => (is_null($post)) ? $post : $post->getUser(),
            'post'            => $post,
            'sections'        => Section::get(),
            'language'        => App::getLocale(),
            'locales'         => config('content.locales'),
            'category'        => $category,
        ]);
    }

    /**
     * Save Base Role.
     *
     * @param null $type
     * @param Post $post
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @internal param null $storage
     */
    public function persist($type = null, Post $post = null)
    {
        $post->setTags($this->request->get('tags', []));

        if ($post->section_id == 0) {
            $post->section_id = null;
        }

        $post->taxonomies()->where('taxonomy', 'category')->detach();

        $category = [];
        foreach ($this->request->get('category', []) as $value) {
            $test = TermTaxonomy::select('id', 'term_id')->find($value);
            $category[] = $test;
        }

        $post->taxonomies()->saveMany($category);
    }
}
