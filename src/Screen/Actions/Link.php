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
        'class' => 'btn btn-link icon-link',
        'icon'  => null,
        'href'  => '#!',
        'turbo' => true,
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
     * Set the link.
     *
     *
     * @return $this
     */
    public function href(string $link = ''): self
    {
        $this->set('href', $link);

        return $this;
    }

    /**
     * @param array $parameters
     * @param bool  $absolute
     *
     * @return $this
     */
    public function route(string $name, $parameters = [], $absolute = true): self
    {
        $route = route($name, $parameters, $absolute);

        return $this->href($route);
    }
}
