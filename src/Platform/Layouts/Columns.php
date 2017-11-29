<?php

namespace Orchid\Platform\Layouts;

abstract class Columns
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.columns";

    /**
     * @param $post
     *
     * @return array
     * @throws \Throwable
     */
    public function build($post)
    {
        foreach ($this->layout() as $key => $layouts) {
            foreach ($layouts as $layout) {
                $build[$key][] = (new $layout)->build($post);
            }
        }

        try {
            $view = view($this->template, [
                'columns' => $build ?? [],
            ])->render();
        } catch (\Throwable $e) {
        }

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
