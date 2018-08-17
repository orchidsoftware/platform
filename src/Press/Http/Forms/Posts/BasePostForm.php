<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Forms\Posts;

use Orchid\Forms\Form;
use Illuminate\View\View;
use Orchid\Press\Models\Post;
use Orchid\Press\Models\Category;
use Orchid\Press\Models\Taxonomy;
use Orchid\Press\Entities\Many as PostEntities;

class BasePostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Information';

    /**
     * BasePostForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('platform::post/base.tabs.information');
        parent::__construct($request);
    }

    /**
     * Display Base Options.
     *
     * @param PostEntities|null $type
     * @param Post|null          $post
     *
     * @return \Illuminate\Contracts\View\Factory|View
     *
     * @internal param null $type
     */
    public function get(PostEntities $type = null, Post $post = null) : View
    {
        $currentCategory = is_null($post) ? [] : $post->taxonomies()->get()->pluck('taxonomy', 'id')->toArray();
        $category = Category::get();

        $category = $category->map(function ($item) use ($currentCategory) {
            $item->active = false;

            if (array_key_exists($item->id, $currentCategory)) {
                $item->active = true;
            }

            return $item;
        });

        return view('platform::container.posts.modules.base', [
            'author'   => (is_null($post)) ? $post : $post->getUser(),
            'post'     => $post,
            'language' => app()->getLocale(),
            'locales'  => config('press.locales'),
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
     * @return void
     *
     * @internal param null $storage
     */
    public function persist($type = null, Post $post = null)
    {
        $post->setTags($this->request->get('tags', []));

        $post->taxonomies()->where('taxonomy', 'category')->detach();

        $category = [];
        foreach ($this->request->get('category', []) as $value) {
            $test = Taxonomy::select('id', 'term_id')->find($value);
            $category[] = $test;
        }

        $post->taxonomies()->saveMany($category);
    }
}
