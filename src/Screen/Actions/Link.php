<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;

/**
 * Class Link.
 *
 * @method Link name(string $name = null)
 * @method Link icon(string $icon = null)
 * @method Link class(string $classes = null)
 * @method Link parameters(array|object $name)
 * @method Link target(string $target = null)
 * @method Link title(string $title = null)
 * @method Link download($download = true)
 */
class Link extends Action
{
    /**
     * @var string
     */
    protected $view = 'platform::actions.link';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'       => 'btn btn-link',
        'icon'        => null,
        'href'        => '#!',
        'turbolinks'  => true,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'autofocus',
        'disabled',
        'tabindex',
        'href',
        'target',
        'title',
        'download',
    ];

    /**
     * Create instance of the button.
     *
     * @param string $name
     *
     * @return self
     */
    public static function make(string $name): Link
    {
        return (new static())
            ->name($name)
            ->addBeforeRender(function () use ($name) {
                $this->set('name', $name);
            });
    }

    /**
     * Set the link.
     *
     * @param string $link
     *
     * @return $this
     */
    public function href(string $link = ''): Link
    {
        $this->set('href', $link);

        return $this;
    }

    /**
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     *
     * @return $this
     */
    public function route(string $name, $parameters = [], $absolute = true): Link
    {
        $route = route($name, $parameters, $absolute);

        return $this->href($route);
    }
}
