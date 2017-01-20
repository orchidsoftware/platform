<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Core\Models\Role;

class SeoPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'SEO';

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
        return view('dashboard::container.posts.modules.base', [
            'author' => (is_null($post)) ? $post : $post->getUser(),
            'post'   => $post,
        ]);
    }

    /**
     * Save Base Role.
     *
     * @param null $storage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist()
    {
    }

    /**
     * @param Role $role
     */
    public function delete()
    {
    }
}
