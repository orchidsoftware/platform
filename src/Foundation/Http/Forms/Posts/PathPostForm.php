<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Services\Forms\Form;

class PathPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Маршрут';

    /**
     * Display Base Options.
     * @param null $type
     * @param Post|null $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($type = null, Post $post = null)
    {
        return view('dashboard::container.posts.modules.path', [
        ]);
    }

    /**
     * @param null $type
     * @param null $post
     */
    public function persist($type = null, $post = null)
    {
        dd($this->request->all());

        $route = $this->request->input('route');

        $content = $post->content;

        foreach ($content as $lang => $item) {
            $content[$lang]['route'] = json_decode($route);
        }

        $post->content = $content;
        $post->save();
    }

    public function delete()
    {
    }
}
