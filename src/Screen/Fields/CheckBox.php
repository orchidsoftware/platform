<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class CheckBox.
 *
 * @method CheckBox accesskey($value = true)
 * @method CheckBox autofocus($value = true)
 * @method CheckBox checked($value = true)
 * @method CheckBox disabled($value = true)
 * @method CheckBox form($value = true)
 * @method CheckBox formaction($value = true)
 * @method CheckBox formenctype($value = true)
 * @method CheckBox formmethod($value = true)
 * @method CheckBox formnovalidate($value = true)
 * @method CheckBox formtarget($value = true)
 * @method CheckBox name(string $value = null)
 * @method CheckBox placeholder(string $value = null)
 * @method CheckBox readonly($value = true)
 * @method CheckBox required(bool $value = true)
 * @method CheckBox tabindex($value = true)
 * @method CheckBox value($value = true)
 * @method CheckBox help(string $value = null)
 * @method CheckBox sendTrueOrFalse($value = true)
 * @method CheckBox title(string $value = null)
 */
class CheckBox extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.checkbox';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'type'     => 'checkbox',
        'class'    => 'custom-control-input',
        'value'    => false,
        'novalue'  => 0,
        'yesvalue' => 1,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accept',
        'accesskey',
        'autocomplete',
        'autofocus',
        'checked',
        'disabled',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'list',
        'max',
        'maxlength',
        'min',
        'name',
        'pattern',
        'placeholder',
        'readonly',
        'required',
        'size',
        'src',
        'step',
        'tabindex',
        'value',
        'type',
        'novalue',
        'yesvalue',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }
}
