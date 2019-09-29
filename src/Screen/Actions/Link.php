<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;

/**
 * Class Link.
 *
 * @method self name(string $name = null)
 * @method self icon(string $icon = null)
 * @method self class(string $classes = null)
 * @method self parameters(array|object $name)
 * @method self target(string $target = null)
 * @method self title(string $title = null)
 * @method self download($download = true)
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
    public static function make(string $name): self
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
    public function href(string $link): self
    {
        $this->set('href', $link);

        return $this;
    }
}
