<?php

declare(strict_types=1);

namespace Orchid\Platform\Fields;

use Closure;
use Orchid\Platform\Core\Models\Post;

class TD
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $width;

    /**
     * @var
     */
    public $filter;

    /**
     * @var
     */
    public $sort;

    /**
     * @var \Closure
     */
    public $render;

    /**
     * @var
     */
    public $column;

    /**
     * @var
     */
    public $align = 'left';

    /**
     * TD constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->column = $name;
    }

    /**
     * @param string $name
     * @param string $title
     * @return TD
     */
    public static function set(string $name, string $title)
    {
        $td = new self($name);
        $td->column = $name;
        $td->title = $title;

        return $td;
    }

    /**
     * @deprecated Use the set method
     *
     * @param string $name
     *
     * @return TD
     */
    public static function name(string $name)
    {
        return new self($name);
    }

    /**
     * @deprecated Use the set method
     *
     * @param string $title
     *
     * @return $this
     */
    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $width
     *
     * @return $this
     */
    public function width(string $width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param string      $filter
     * @param string|null $column
     *
     * @return $this
     */
    public function filter(string $filter, string $column = null)
    {
        $this->filter = $filter;
        $this->column = $column ?? $this->name;

        return $this;
    }

    /**
     * @param string|null $column
     *
     * @return $this
     */
    public function sort(string $column = null)
    {
        $this->sort = true;

        if (!is_null($column)) {
            $this->column = $column;
        }

        return $this;
    }

    /**
     * @param \Closure $closure
     *
     * @return $this
     */
    public function setRender(Closure $closure)
    {
        $this->render = $closure;

        return $this;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function handler($data)
    {
        return ($this->render)($data);
    }

    /**
     * @param string|null $text
     *
     * @return TD
     */
    public function linkPost(string $text = null)
    {
        return $this->link('dashboard.posts.type.edit', ['type', 'slug'], $text);
    }

    /**
     * @param string $route
     * @param        $options
     * @param string $text
     *
     * @return TD
     */
    public function link(string $route, $options, string $text = null)
    {

        return $this->setRender(function (Post $datum) use ($route, $options, $text) {

            $attributes = [];

            if (!is_array($options)) {
                $options = [$options];
            }

            foreach ($options as $option) {
                $attributes[] = $datum->getContent($option);
            }

            if (!is_null($text)) {
                $text = $datum->getContent($text);
            }

            return view('dashboard::partials.td.link', [
                'route'      => $route,
                'attributes' => $attributes,
                'text'       => $text
            ]);

        });
    }

    /**
     * @param string $align
     *
     * @return $this
     */
    public function align(string $align){
        $this->align = $align;

        return $this;
    }

}
