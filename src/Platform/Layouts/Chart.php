<?php

declare(strict_types=1);

namespace Orchid\Platform\Layouts;

abstract class Chart
{
    /**
     * @var string
     */
    public $template = 'dashboard::container.layouts.chart';

    /**
     * @var string
     */
    public $title = 'My Chart';

    /**
     * Available options:
     * 'bar', 'line', 'scatter',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    public $type = 'line';

    /**
     * @var int
     */
    public $height = 250;

    /**
     * @var array
     */
    public $labels = [];

    /**
     * @var array
     */
    public $data = '';

    /**
     * @param $post
     *
     * @return array
     * @throws \Throwable
     */
    public function build($post)
    {
        return view($this->template, [
            'title'  => $this->title,
            'slug'   => str_slug($this->title),
            'type'   => $this->type,
            'height' => $this->height,
            'labels' => json_encode(collect($this->labels)),
            'data'   => json_encode($post->getContent($this->data)),
        ])->render();
    }
}
