<?php

namespace Orchid\Platform\Layouts;

abstract class Colums
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.colums";

    /**
     * @return array
     */
    public function layout() : array
    {
        return [];
    }

    /**
     * @param $post
     *
     * @return array
     */
    public function build($post)
    {
        foreach ($this->layout() as $key => $layouts) {
            foreach ($layouts as $layout) {
                $build[$key][] = (new $layout)->build($post);
            }
        }

        $view = view($this->template, [
            'colums' => $build ?? [],
        ])->render();

        return $view;
    }
}
