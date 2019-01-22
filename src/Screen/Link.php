<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Orchid\Screen\Traits\CanSee;

/**
 * Class Link.
 *
 * @method static Link name(string $name)
 * @method static Link modal(string $name)
 * @method static Link title(string $name)
 * @method static Link method(string $name)
 * @method static Link icon(string $name)
 * @method static Link link(string $name)
 * @method static Link group(array $name)
 */
class Link
{
    use CanSee;

    /**
     * @var
     */
    public $slug;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $method;

    /**
     * @var
     */
    public $icon;

    /**
     * @var
     */
    public $modal;

    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $link;

    /**
     * @var array
     */
    public $group = [];

    /**
     * @var string
     */
    public $view;

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return (new static)->rewriteProperty($name, $arguments[0]);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func([$this, 'rewriteProperty'], $name, $arguments[0]);
    }

    /**
     * @param Repository $query
     * @param null $arguments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function build($query, $arguments = null)
    {
        if (! $this->display) {
            return;
        }

        if (! is_null($this->view)) {
            return view($this->view, $query->all());
        }

        return view('platform::container.layouts.link', [
            'slug'      => $this->slug,
            'name'      => $this->name,
            'method'    => $this->method,
            'icon'      => $this->icon,
            'modal'     => $this->modal,
            'title'     => $this->title,
            'link'      => $this->link,
            'group'     => $this->group,
            'arguments' => $arguments,
            'query'     => $query,
        ]);
    }

    /**
     * @param $name
     * @param $property
     *
     * @return $this
     */
    protected function rewriteProperty($name, $property)
    {
        $this->$name = $property;

        return $this;
    }

    /**
     * @param array $links
     *
     * @return $this
     */
    public function dropdown(array $links)
    {
        $this->group = $links;

        return $this;
    }

    /**
     * @param string $view
     *
     * @return $this
     */
    public static function view(string $view)
    {
        $link = new static;
        $link->view = $view;

        return $link;
    }
}
