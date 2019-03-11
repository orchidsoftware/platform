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
     * @var string|null
     */
    public $name;

    /**
     * @var string
     */
    public $method;

    /**
     * @var string|null
     */
    public $icon;

    /**
     * @var string|null
     */
    public $modal;

    /**
     * @var string|null
     */
    public $title;

    /**
     * @var string|null
     */
    public $link;

    /**
     * @var array
     */
    public $group = [];

    /**
     * @var string|null
     */
    public $view;

    /**
     * @param string     $name
     * @param mixed|null $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, $arguments)
    {
        return (new static())->rewriteProperty($name, $arguments[0]);
    }

    /**
     * @param string     $name
     * @param mixed|null $arguments
     *
     * @return self
     */
    public function __call(string $name, $arguments) : self
    {
        return $this->rewriteProperty($name, $arguments[0]);
    }

    /**
     * @param Repository $query
     * @param null       $arguments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function build(Repository $query, $arguments = null)
    {
        if (! $this->display) {
            return;
        }

        if (! is_null($this->view)) {
            return view($this->view, $query->all());
        }

        return view('platform::container.layouts.link', [
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
     * @param string     $name
     * @param mixed|null $property
     *
     * @return self
     */
    protected function rewriteProperty(string $name, $property) : self
    {
        $this->$name = $property;

        return $this;
    }

    /**
     * @param Link[] $links
     *
     * @return self
     */
    public function dropdown(array $links) : self
    {
        $this->group = $links;

        return $this;
    }

    /**
     * @param string $view
     *
     * @return self
     */
    public static function view(string $view): self
    {
        $link = new static();
        $link->view = $view;

        return $link;
    }
}
