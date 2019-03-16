<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Button.
 *
 * @method self modal(string $modalName = null)
 * @method self icon(string $icon = null)
 * @method self class(string $classes = null)
 * @method self method(string $methodName = null)
 */
class Button extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.button';

    /**
     * Override the form view.
     *
     * @var string
     */
    public $typeForm = 'platform::partials.fields.clear';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'  => 'btn btn-primary',
        'modal'  => null,
        'method' => null,
        'icon'   => null,
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
    ];

    /**
     * Create instance of the button.
     *
     * @return self
     */
    public static function make(): self
    {
        return (new static())->name('button');
    }

    /**
     * Set the link.
     *
     * @param string $link
     *
     * @return \Orchid\Screen\Field
     */
    public function link(string $link)
    {
        return $this->set('href', $link);
    }

    /**
     * Align button to the right.
     *
     * @return $this
     */
    public function right()
    {
        $this->attributes['class'] .= ' pull-right';

        return $this;
    }

    /**
     * Set the button as block.
     *
     * @return $this
     */
    public function block()
    {
        $this->attributes['class'] .= ' btn-block';

        return $this;
    }
}
