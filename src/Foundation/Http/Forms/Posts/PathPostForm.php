<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Post;

class PathPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Маршрут';

    /**
     * Display Base Options.
     *
     * @param Post|null $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @internal param null $type
     */
    public function get(Post $type = null, Post $post = null)
    {
        $route = [];

        if (!is_null($post)) {
            $content = $post->getAttribute('content');

            if (isset($content['route'])) {
                $route = $content['route'];
            }
        }

        $route_json = json_encode($route);

        return view('dashboard::container.posts.modules.path', [
            'route' => $route_json,
        ]);
    }

    /**
     * @param null $type
     * @param null $post
     *
     * @return mixed|void
     */
    public function persist($type = null, $post = null)
    {
        $route = $this->request->input('route');

        $content = $post->content;

        $content['route'] = json_decode($route);

        $post->content = $content;
        $post->save();
    }

    public function delete()
    {
    }
}
