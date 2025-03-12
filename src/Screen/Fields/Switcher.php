<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Switcher.
 *
* @method static accesskey($value = true)
* @method static autocomplete($value = true)
* @method static autofocus($value = true)
* @method static checked($value = true)
* @method static disabled($value = true)
* @method static form($value = true)
* @method static formaction($value = true)
* @method static formenctype($value = true)
* @method static formmethod($value = true)
* @method static formnovalidate($value = true)
* @method static formtarget($value = true)
* @method static name(string $value = null)
* @method static placeholder(string $value = null)
* @method static readonly($value = true)
* @method static required(bool $value = true)
* @method static tabindex($value = true)
* @method static value($value = true)
* @method static help(string $value = null)
* @method static sendTrueOrFalse($value = true)
* @method static title(string $value = null)
 */
class Switcher extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.switch';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'type'     => 'checkbox',
        'class'    => 'form-check-input',
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
