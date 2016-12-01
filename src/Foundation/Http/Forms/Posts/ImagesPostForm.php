<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Services\Forms\Form;

class ImagesPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Изображения';

    /**
     * Display Base Options.
     * @param null $type
     * @param Post|null $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($type = null, Post $post = null)
    {
        return view('dashboard::container.posts.modules.images', [
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
