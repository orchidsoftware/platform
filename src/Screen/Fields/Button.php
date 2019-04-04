<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;
use Illuminate\Support\Str;

/**
 * Class Button.
 *
 * @method self name(string $name = null)
 * @method self modal(string $modalName = null)
 * @method self icon(string $icon = null)
 * @method self class(string $classes = null)
 * @method self method(string $methodName = null)
 */
class Button extends Field
{
    /**
     * Visual style.
     */
    const DEFAULT = 'btn-default';
    const SUCCESS = 'btn-success';
    const WARNING = 'btn-warning';
    const DANGER = 'btn-danger';
    const INFO = 'btn-info';
    const PRIMARY = 'btn-primary';
    const SECONDARY = 'btn-secondary';
    const LIGHT = 'btn-light';
    const DARK = 'btn-dark';
    const LINK = 'btn-link';

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
        'class'  => 'btn btn-default',
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
        return (new static())->name(Str::random());
    }

    /**
     * Set the link.
     *
     * @param string $link
     *
     * @return $this
     */
    public function link(string $link): self
    {
        $this->set('href', $link);

        return $this;
    }

    /**
     * Align button to the right.
     *
     * @return $this
     */
    public function right(): self
    {
        $class = $this->get('class').' pull-right';

        $this->set('class', $class);

        return $this;
    }

    /**
     * @param string $visual
     *
     * @return $this
     */
    public function type(string $visual): self
    {
        $class = str_replace([
            self::DEFAULT,
            self::SUCCESS,
            self::WARNING,
            self::DANGER,
            self::INFO,
            self::PRIMARY,
            self::SECONDARY,
            self::LIGHT,
            self::DARK,
            self::LINK,
        ], '', $this->get('class'));

        $this->set('class', $class.' '.$visual);

        return $this;
    }

    /**
     * Set the button as block.
     *
     * @return $this
     */
    public function block(): self
    {
        $class = $this->get('class').' pull-block';

        $this->set('class', $class);

        return $this;
    }
}
