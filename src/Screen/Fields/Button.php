<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Support\Str;
use Orchid\Screen\Field;

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
    public const DEFAULT = 'btn-default';
    public const SUCCESS = 'btn-success';
    public const WARNING = 'btn-warning';
    public const DANGER = 'btn-danger';
    public const INFO = 'btn-info';
    public const PRIMARY = 'btn-primary';
    public const SECONDARY = 'btn-secondary';
    public const LIGHT = 'btn-light';
    public const DARK = 'btn-dark';
    public const LINK = 'btn-link';

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
        'class' => 'btn btn-default',
        'modal' => null,
        'method' => null,
        'async' => false,
        'async_params' => [],
        'icon' => null,
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
        $class = $this->get('class') . ' pull-right';

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
        ], '', (string)$this->get('class'));

        $this->set('class', $class . ' ' . $visual);

        return $this;
    }


    public function loadModalAsync(string $modal, $method, $options, string $text = null): self
    {
        $this->set('async', true);
        $this->set('modal', $modal);
        $this->set('method', $method);
        $this->set('async_params', $options);

        return $this;
    }

    /**
     * Set the button as block.
     *
     * @return $this
     */
    public function block(): self
    {
        $class = $this->get('class') . ' pull-block';

        $this->set('class', $class);

        return $this;
    }
}
