<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Password.
 *
 * @method Password accept($value = true)
 * @method Password accesskey($value = true)
 * @method Password autocomplete($value = true)
 * @method Password autofocus($value = true)
 * @method Password checked($value = true)
 * @method Password disabled($value = true)
 * @method Password form($value = true)
 * @method Password formaction($value = true)
 * @method Password formenctype($value = true)
 * @method Password formmethod($value = true)
 * @method Password formnovalidate($value = true)
 * @method Password formtarget($value = true)
 * @method Password max(int $value)
 * @method Password maxlength(int $value)
 * @method Password min(int $value)
 * @method Password name(string $value = null)
 * @method Password pattern($value = true)
 * @method Password placeholder(string $value = null)
 * @method Password readonly($value = true)
 * @method Password required(bool $value = true)
 * @method Password size($value = true)
 * @method Password tabindex($value = true)
 * @method Password help(string $value = null)
 * @method Password popover(string $value = null)
 * @method Password title(string $value = null)
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
