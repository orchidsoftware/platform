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
        $route_json = null;

        if ($post != null) {
            $content = $post->getAttribute('content');

            $route = $content['route'];

            $route_json = json_encode($route);

//            dd($route_json);
        }

        return view('dashboard::container.posts.modules.path', [
            'route' => $route_json,
        ]);
    }

    /**
     * @param null $type
     * @param null $post
     * @return mixed|void
     */
    public function persist($type = null, $post = null)
    {
        $route = $this->request->input('route');

        $content = $post->content;

        foreach ($content as $lang => $item) {
            $content['route'] = json_decode($route);
        }

        $post->content = $content;
        $post->save();
    }

    public function delete()
    {
    }
}
