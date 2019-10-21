<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Input.
 *
 * @method UTM accept($value = true)
 * @method UTM accesskey($value = true)
 * @method UTM autocomplete($value = true)
 * @method UTM autofocus($value = true)
 * @method UTM checked($value = true)
 * @method UTM disabled($value = true)
 * @method UTM form($value = true)
 * @method UTM formaction($value = true)
 * @method UTM formenctype($value = true)
 * @method UTM formmethod($value = true)
 * @method UTM formnovalidate($value = true)
 * @method UTM formtarget($value = true)
 * @method UTM list($value = true)
 * @method UTM max(int $value)
 * @method UTM maxlength(int $value)
 * @method UTM min(int $value)
 * @method UTM multiple($value = true)
 * @method UTM name(string $value = null)
 * @method UTM pattern($value = true)
 * @method UTM placeholder(string $value = null)
 * @method UTM readonly($value = true)
 * @method UTM required(bool $value = true)
 * @method UTM size($value = true)
 * @method UTM src($value = true)
 * @method UTM step($value = true)
 * @method UTM tabindex($value = true)
 * @method UTM type($value = true)
 * @method UTM value($value = true)
 * @method UTM help(string $value = null)
 * @method UTM mask($value = true)
 * @method UTM popover(string $value = null)
 */
class UTM extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.utm';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'type'  => 'url',
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
        'multiple',
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
