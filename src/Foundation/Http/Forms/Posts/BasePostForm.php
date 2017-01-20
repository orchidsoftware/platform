<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Forms\Form;
use Illuminate\Support\Facades\App;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Core\Models\Section;

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
        return view('dashboard::container.posts.modules.base', [
            'author' => (is_null($post)) ? $post : $post->getUser(),
            'post' => $post,
            'sections' => Section::get(),
            'language' => App::getLocale(),
        ]);
    }

    /**
     * Save Base Role.
     *
     * @param null $storage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist($type = null, Post $post = null)
    {
        $post->setTags($this->request->input('tags'));

        if ($post->section_id == 0) {
            $post->section_id = null;
        }
    }

    /**
     * @param Role $role
     */
    public function delete()
    {
    }
}
