<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;

class TD
{
    use Macroable, CanSee;

    /**
     * Align the cell to the left.
     */
    public const ALIGN_LEFT = 'left';

    /**
     * Align the cell to the center.
     */
    public const ALIGN_CENTER = 'center';

    /**
     * Align the cell to the right.
     */
    public const ALIGN_RIGHT = 'right';

    public const FILTER_TEXT = 'text';
    public const FILTER_NUMERIC = 'numeric';
    public const FILTER_DATE = 'date';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $width;

    /**
     * @var string
     */
    protected $filter;

    /**
     * @var bool
     */
    protected $sort;

    /**
     * @var Closure|null
     */
    protected $render;

    /**
     * @var string
     */
    protected $column;

    /**
     * @deprecated
     *
     * @var string
     */
    protected $asyncRoute;

    /**
     * @var string
     */
    protected $align = 'left';

    /**
     * @deprecated
     *
     * @var bool
     */
    protected $locale = false;

    /**
     * Displays whether the user can hide
     * or show the column in the browser.
     *
     * @var bool
     */
    protected $allowUserHidden = true;

    /**
     * Should the user independently enable
     * the display of the column.
     *
     * @var bool
     */
    protected $defaultHidden = false;

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
     * @param string      $name
     * @param string|null $title
     *
     * @return TD
     */
    public static function set(string $name, string $title = null): self
    {
        $td = new static($name);
        $td->column = $name;
        $td->title = $title ?? Str::title($name);

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
     * @deprecated
     *
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
     * @return TD
     */
    public function sort(bool $sort = true): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @param Repository|AsSource $source
     *
     * @return mixed
     */
    protected function handler($source)
    {
        return with($source, $this->render);
    }

    /**
     * @deprecated Use Link class
     *
     * @param string      $route
     * @param mixed       $options
     * @param string|null $text
     *
     * @return TD
     */
    public function link(string $route, $options, string $text = null): self
    {
        $this->render(static function ($datum) use ($route, $options, $text) {
            $attributes = [];
            $options = Arr::wrap($options);

            foreach ($options as $option) {
                if (method_exists($datum, 'getContent')) {
                    $attributes[] = $datum->getContent($option);
                    continue;
                }

                $attributes[] = $datum->getAttribute($option);
            }

            if (! is_null($text)) {
                $text = $datum->getContent($text);
                $text = $text ?? '—';
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
     * @param Closure $closure
     *
     * @return $this
     */
    public function render(Closure $closure): self
    {
        $this->render = $closure;

        return $this;
    }

    /**
     * @deprecated Use ModalToggle class
     *
     * @param string       $modal
     * @param string       $method
     * @param string|array $options
     * @param string|null  $text
     *
     * @return TD
     */
    public function loadModalAsync(string $modal, string $method, $options, string $text = null): self
    {
        $this->render(function ($datum) use ($modal, $method, $options, $text) {
            $attributes = [];
            $options = Arr::wrap($options);

            foreach ($options as $option) {
                if (method_exists($datum, 'getContent')) {
                    $attributes[] = $datum->getContent($option);
                    continue;
                }

                $attributes[] = $datum->getAttribute($option);
            }

            $text = $datum->getContent($text) ?: $text;

            return view('platform::partials.td.async', [
                'modal'      => $modal,
                'attributes' => $attributes,
                'text'       => $text,
                'method'     => $method,
                'title'      => $this->title,
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
     * @deprecated
     *
     * @param string $route
     *
     * @return $this
     */
    public function asyncRoute(string $route): self
    {
        $this->asyncRoute = $route;

        return $this;
    }

    /**
     * Builds a column heading.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function buildTh()
    {
        return view('platform::partials.layouts.th', [
            'width'        => $this->width,
            'align'        => $this->align,
            'sort'         => $this->sort,
            'column'       => $this->column,
            'title'        => $this->title,
            'filter'       => $this->filter,
            'filterString' => get_filter_string($this->column),
            'slug'         => $this->sluggable(),
        ]);
    }

    /**
     * Builds content for the column.
     *
     * @param Repository|AsSource $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function buildTd($repository)
    {
        $value = $this->render
            ? $this->handler($repository)
            : $repository->getContent($this->name);

        return view('platform::partials.layouts.td', [
            'align'  => $this->align,
            'value'  => $value,
            'render' => $this->render,
            'slug'   => $this->sluggable(),
        ]);
    }

    /**
     * Builds item menu for show/hiden column.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    public function buildItemMenu()
    {
        if (! $this->allowUserHidden) {
            return;
        }

        return view('platform::partials.layouts.selectedTd', [
            'title'         => $this->title,
            'slug'          => $this->sluggable(),
            'defaultHidden' => var_export($this->defaultHidden, true),
        ]);
    }

    /**
     * @return string
     */
    private function sluggable(): string
    {
        return Str::slug($this->name);
    }

    /**
     * Prevents the user from hiding a column in the interface.
     *
     * @param bool $hidden
     *
     * @return TD
     */
    public function canHide($hidden = false): self
    {
        $this->allowUserHidden = $hidden;

        return $this;
    }

    /**
     * @param bool $hidden
     *
     * @return $this
     */
    public function defaultHidden($hidden = true): self
    {
        $this->defaultHidden = $hidden;

        return $this;
    }
}
