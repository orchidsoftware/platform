<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Closure;

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
     * @var string
     */
    public $asyncRoute;

    /**
     * @var
     */
    public $align = 'left';

    /**
     * @var bool
     */
    public $locale = false;

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
     *
     * @return TD
     */
    public static function set(string $name, string $title)
    {
        $td = new static($name);
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
        return new static($name);
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
     * Set current columns is multi language.
     *
     * @return $this
     */
    public function locale()
    {
        $this->locale = true;

        return $this;
    }

    /**
     * @param string|null $column
     *
     * @return $this
     */
    public function column(string $column = null)
    {
        if (!is_null($column)) {
            $this->column = $column;
        }

        if (!is_null($column) && $this->locale) {
            $locale = '.'.app()->getLocale().'.';
            $this->column = preg_replace('/'.preg_quote('.', '/').'/', $locale, $column);
        }

        return $this;
    }

    /**
     * @param string $filter
     *
     * @return $this
     */
    public function filter(string $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @return $this
     */
    public function sort()
    {
        $this->sort = true;

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
        return $this->link('platform.posts.type.edit', ['type', 'slug'], $text);
    }

    /**
     * @param string $route
     * @param        $options
     * @param string $text
     *
     * @return TD
     */
    public function link(string $route, $options, string $text = null): self
    {
        $this->setRender(function($datum) use ($route, $options, $text) {
            $attributes = [];

            if (!is_array($options)) {
                $options = [$options];
            }

            foreach ($options as $option) {
                if (method_exists($datum, 'getContent')) {
                    $attributes[] = $datum->getContent($option);
                    continue;
                }

                $attributes[] = $datum->getAttribute($option);
            }

            if (!is_null($text)) {
                $text = $datum->getContent($text);
            }

            return view('platform::partials.td.link', [
                'route'      => $route,
                'attributes' => $attributes,
                'text'       => $text,
            ]);
        });

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
     * @param string      $modal
     * @param             string $method
     * @param             string $options
     * @param string|null $text
     *
     * @return \Orchid\Screen\Fields\TD
     */
    public function loadModalAsync(string $modal, $method, $options, string $text = null): self
    {
        $this->setRender(function($datum) use ($modal, $method, $options, $text) {
            $attributes = [];

            if (!is_array($options)) {
                $options = [$options];
            }

            foreach ($options as $option) {
                if (method_exists($datum, 'getContent')) {
                    $attributes[] = $datum->getContent($option);
                    continue;
                }

                $attributes[] = $datum->getAttribute($option);
            }

            if (!is_null($text)) {
                $text = $datum->getContent($text);
            }

            return view('platform::partials.td.async', [
                'modal'      => $modal,
                'attributes' => $attributes,
                'text'       => $text,
                'method'     => $method,
                'route'      => $this->asyncRoute,
            ]);
        });

        return $this;
    }

    /**
     * @param string $align
     *
     * @return $this
     */
    public function align(string $align)
    {
        $this->align = $align;

        return $this;
    }

    /**
     * @param string $route
     *
     * @return $this
     */
    public function asyncRoute(string $route) : self
    {
        $this->asyncRoute = $route;

        return $this;
    }
}
