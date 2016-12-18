<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Foundation\Services\Forms\Form;

class PathPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Маршрут';

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
