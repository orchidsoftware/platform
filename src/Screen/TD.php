<?php

declare(strict_types=1);

namespace Orchid\Screen;

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
    public static function set(string $name, string $title = null): self
    {
        $td = new static($name);
        $td->column = $name;
        $td->title = is_null($title) ? title_case($name) : $title;

        return $td;
    }

    /**
     * @param string $width
     *
     * @return TD
     */
    public function width(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set current columns is multi language.
     *
     * @return TD
     */
    public function locale(): self
    {
        $this->locale = true;

        return $this;
    }

    /**
     * @param string|null $column
     *
     * @return TD
     */
    public function column(string $column = null): self
    {
        if (! is_null($column)) {
            $this->column = $column;
        }

        if ($this->locale && ! is_null($column)) {
            $locale = '.'.app()->getLocale().'.';
            $this->column = preg_replace('/'.preg_quote('.', '/').'/', $locale, $column);
        }

        return $this;
    }

    /**
     * @param string $filter
     *
     * @return TD
     */
    public function filter(string $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param bool $sort
     *
     * @return \Orchid\Screen\TD
     */
    public function sort(bool $sort = true): self
    {
        $this->sort = $sort;

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
    public function linkPost(string $text = null): self
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
        $this->setRender(function ($datum) use ($route, $options, $text) {
            $attributes = [];
            $options = array_wrap($options);

            foreach ($options as $option) {
                if (method_exists($datum, 'getContent')) {
                    $attributes[] = $datum->getContent($option);
                    continue;
                }

                $attributes[] = $datum->getAttribute($option);
            }

            if (! is_null($text)) {
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
    public function setRender(Closure $closure): self
    {
        $this->render = $closure;

        return $this;
    }

    /**
     * @param string $modal
     * @param             string $method
     * @param             string $options
     * @param string|null $text
     *
     * @return \Orchid\Screen\TD
     */
    public function loadModalAsync(string $modal, $method, $options, string $text = null): self
    {
        $this->setRender(function ($datum) use ($modal, $method, $options, $text) {
            $attributes = [];
            $options = array_wrap($options);

            foreach ($options as $option) {
                if (method_exists($datum, 'getContent')) {
                    $attributes[] = $datum->getContent($option);
                    continue;
                }

                $attributes[] = $datum->getAttribute($option);
            }

            $text = is_null($text) ? $text : $datum->getContent($text);

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
    public function align(string $align): self
    {
        $this->align = $align;

        return $this;
    }

    /**
     * @param string $route
     *
     * @return $this
     */
    public function asyncRoute(string $route): self
    {
        $this->asyncRoute = $route;

        return $this;
    }
}
