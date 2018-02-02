<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Posts;

use Illuminate\View\View;
use Orchid\Platform\Forms\Form;
use Illuminate\Support\Facades\App;
use Orchid\Platform\Core\Models\Post;
use Orchid\Platform\Core\Models\Category;
use Orchid\Platform\Core\Models\Taxonomy;
use Orchid\Platform\Behaviors\Many as PostBehaviors;

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
        $this->name = trans('dashboard::post/base.tabs.information');
        parent::__construct($request);
    }

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
    public function get(PostBehaviors $type = null, Post $post = null) : View
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
            'locales'  => config('platform.locales'),
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
