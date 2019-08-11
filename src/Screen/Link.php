<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;
use Orchid\Screen\Contracts\ActionContract;

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
 * @method static Link confirm(string $message)
 * @method static Link parameters(array|object $name)
 */
class Link implements ActionContract
{
    use CanSee;

    /**
     * @var string|null
     */
    public $name;

    /**
     * Name of the method to be executed on click.
     *
     * @var string
     */
    public $method;

    /**
     * @var string|null
     */
    public $icon;

    /**
     * The unique name of the modal window.
     *
     * @var string|null
     */
    public $modal;

    /**
     * Header for modal window.
     *
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
     * Confirmation message.
     *
     * @var string|null
     */
    public $confirm;

    /**
     * URL-encoded query string.
     *
     * If query_data is an array, it may be a simple
     * one-dimensional structure, or an array
     * of arrays (which in turn may contain other arrays).
     *
     * If query_data is an object, then only public
     * properties will be incorporated into the result.
     *
     * @var object|array
     */
    public $parameters = [];

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
     *
     * @return Factory|View|mixed|void
     */
    public function build(Repository $query)
    {
        if (! $this->isSee()) {
            return;
        }

        if (! is_null($this->view)) {
            return view($this->view, $query->all());
        }

        return view('platform::layouts.link', [
            'name'      => $this->name,
            'method'    => $this->method,
            'icon'      => $this->icon,
            'modal'     => $this->modal,
            'title'     => $this->title,
            'link'      => $this->link,
            'group'     => $this->group,
            'confirm'   => $this->confirm,
            'action'    => $this->action(),
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

    /**
     * Returns URL to which the form should be sent.
     *
     * @return string
     */
    public function action() : string
    {
        $url = url()->current();
        $query = http_build_query($this->parameters);

        return "{$url}/{$this->method}?{$query}";
    }
}
