<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Quill.
 *
* @method static autofocus($value = true)
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
* @method static height($value = '300px')
* @method static title(string $value = null)
* @method static popover(string $value = null)
* @method static toolbar(array $options)
* @method static base64(bool $value = true)
* @method static groups(string $value = null)
 */
class Quill extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.quill';

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    protected $attributes = [
        'value'   => null,
        'toolbar' => ['text', 'color', 'quote', 'header', 'list', 'format', 'media'],
        'height'  => '300px',
        'base64'  => false,
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
        'step',
        'tabindex',
        'height',
        'groups',
    ];
}
