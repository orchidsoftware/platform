<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Switcher.
 *
 * @method Switcher accesskey($value = true)
 * @method Switcher autocomplete($value = true)
 * @method Switcher autofocus($value = true)
 * @method Switcher checked($value = true)
 * @method Switcher disabled($value = true)
 * @method Switcher form($value = true)
 * @method Switcher formaction($value = true)
 * @method Switcher formenctype($value = true)
 * @method Switcher formmethod($value = true)
 * @method Switcher formnovalidate($value = true)
 * @method Switcher formtarget($value = true)
 * @method Switcher name(string $value = null)
 * @method Switcher placeholder(string $value = null)
 * @method Switcher readonly($value = true)
 * @method Switcher required(bool $value = true)
 * @method Switcher tabindex($value = true)
 * @method Switcher value($value = true)
 * @method Switcher help(string $value = null)
 * @method Switcher sendTrueOrFalse($value = true)
 * @method Switcher title(string $value = null)
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
