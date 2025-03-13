<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Quill.
 *
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this formaction($value = true)
 * @method $this formenctype($value = true)
 * @method $this formmethod($value = true)
 * @method $this formnovalidate($value = true)
 * @method $this formtarget($value = true)
 * @method $this name(string $value = null)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required(bool $value = true)
 * @method $this tabindex($value = true)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this height($value = '300px')
 * @method $this title(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this toolbar(array $options)
 * @method $this base64(bool $value = true)
 * @method $this groups(string $value = null)
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
