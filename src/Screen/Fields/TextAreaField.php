<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class TextAreaField.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this cols($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this maxlength($value = true)
 * @method $this name(string $value)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required($value = true)
 * @method $this rows(int $value)
 * @method $this tabindex($value = true)
 * @method $this wrap($value = true)
 * @method $this help(string $value = null)
 * @method $this max(int $value)
 * @method $this popover(string $value = null)
 */
class TextAreaField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.textarea';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class' => 'form-control no-resize',
        'value' => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accesskey',
        'autofocus',
        'cols',
        'disabled',
        'form',
        'maxlength',
        'name',
        'placeholder',
        'readonly',
        'required',
        'rows',
        'tabindex',
        'wrap',
    ];

    /**
     * @param string|null $name
     * @return TextAreaField
     */
    public static function make(string $name = null): self
    {
        return (new static)->name($name);
    }
}
