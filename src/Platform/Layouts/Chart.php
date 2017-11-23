<?php

namespace Orchid\Platform\Layouts;

abstract class Chart
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.chart";

    /**
     * @var string
     */
    public $title = 'My Chart';

    /**
     * Available options:
     * 'bar', 'line', 'scatter',
     * 'pie', 'percentage'
     *
     * @var string
     */
    public $type = 'line';

    /**
     * @var int
     */
    public $height = 250;

    /**
     * @param $post
     *
     * @return array
     */
    public function build($post)
    {
        $view = view($this->template, [
            'title' => $this->title,
            'slug' => str_slug($this->title),
            'type' => $this->type,
            'height' => $this->height,
            'labels' => $this->labels(),
            'data' => $this->data(),
        ])->render();

        return $view;
    }

    /**
     * @return array
     */
    public function labels() : array
    {
        return [];
    }

    /**
     * @return array
     */
    public function data() : array
    {
        return [
            'title' => [],
            'value' => [],
        ];
    }
}
