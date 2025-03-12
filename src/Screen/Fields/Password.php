<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Password.
 *
 * @method static accept($value = true)
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
 * @method static max(int $value)
 * @method static maxlength(int $value)
 * @method static min(int $value)
 * @method static name(string $value = null)
 * @method static pattern($value = true)
 * @method static placeholder(string $value = null)
 * @method static readonly($value = true)
 * @method static required(bool $value = true)
 * @method static size($value = true)
 * @method static tabindex($value = true)
 * @method static help(string $value = null)
 * @method static popover(string $value = null)
 * @method static title(string $value = null)
 */
class Password extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.password';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'type'  => 'password',
        'class' => 'form-control',
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
        'type',
    ];
}
