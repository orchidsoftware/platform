<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class RadioButtonsField.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this name(string $value)
 * @method $this required($value = true)
 * @method $this size($value = true)
 * @method $this tabindex($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 */
class RadioButtonsField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.radiobutton';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'type' => 'radio'
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'multiple',
        'name',
        'required',
        'size',
        'tabindex',
        'type'
    ];

    /**
     * @param string|null $name
     * @return SelectField
     */
    public static function make(string $name = null): self
    {
        return (new static)->name($name);
    }
}
