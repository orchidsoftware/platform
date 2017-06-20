<?php

namespace Orchid\Http\Forms\Posts;

use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Orchid\Behaviors\Many as PostBehaviors;
use Orchid\Core\Models\Category;
use Orchid\Core\Models\Post;
use Orchid\Core\Models\TermTaxonomy;
use Orchid\Forms\Form;

class BasePostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'General';

    /**
     * Display Base Options.
     *
     * @param PostBehaviors|null $type
     * @param Post|null          $post
     *
     * @return \Illuminate\Contracts\View\Factory|View
     *
     * @internal param null $type
     */
    public function get(PostBehaviors $type = null, Post $post = null): View
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
            'author'   => (is_null($post)) ? $post : $post->getUser(),
            'post'     => $post,
            'language' => App::getLocale(),
            'locales'  => config('content.locales'),
            'category' => $category,
            'type'     => $type,
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

        $post->taxonomies()->where('taxonomy', 'category')->detach();

        $category = [];
        foreach ($this->request->get('category', []) as $value) {
            $test = TermTaxonomy::select('id', 'term_id')->find($value);
            $category[] = $test;
        }

        $post->taxonomies()->saveMany($category);
    }
}
