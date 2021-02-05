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
 * @method CheckBox indeterminate(bool $status = true)
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
        'type'          => 'checkbox',
        'class'         => 'form-check-input',
        'value'         => false,
        'novalue'       => 0,
        'yesvalue'      => 1,
        'indeterminate' => false,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accesskey',
        'autofocus',
        'checked',
        'disabled',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'name',
        'placeholder',
        'readonly',
        'required',
        'tabindex',
        'value',
        'type',
        'novalue',
        'yesvalue',
    ];
}
