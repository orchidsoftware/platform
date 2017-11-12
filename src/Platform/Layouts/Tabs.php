<?php

namespace Orchid\Platform\Layouts;

abstract class Tabs
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.tabs";

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
            'tabs' => $build ?? [],
        ])->render();

        return $view;
    }

    /**
     * @return array
     */
    public function layout() : array
    {
        return [];
    }
}
