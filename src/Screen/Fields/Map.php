<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Map.
 *
 * @method Map accept($value = true)
 * @method Map accesskey($value = true)
 * @method Map autocomplete($value = true)
 * @method Map autofocus($value = true)
 * @method Map checked($value = true)
 * @method Map disabled($value = true)
 * @method Map form($value = true)
 * @method Map formaction($value = true)
 * @method Map formenctype($value = true)
 * @method Map formmethod($value = true)
 * @method Map formnovalidate($value = true)
 * @method Map formtarget($value = true)
 * @method Map list($value = true)
 * @method Map max(int $value)
 * @method Map maxlength(int $value)
 * @method Map min(int $value)
 * @method Map multiple($value = true)
 * @method Map name(string $value = null)
 * @method Map pattern($value = true)
 * @method Map placeholder(string $value = null)
 * @method Map readonly($value = true)
 * @method Map required(bool $value = true)
 * @method Map size($value = true)
 * @method Map src($value = true)
 * @method Map step($value = true)
 * @method Map tabindex($value = true)
 * @method Map type($value = true)
 * @method Map value($value = true)
 * @method Map help(string $value = null)
 * @method Map popover(string $value = null)
 * @method Map zoom($value = true)
 * @method Map height($value = '300px')
 */
class Map extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.map';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'zoom'   => 14,
        'height' => '300px',
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
        'type',
        'value',
        'height',
    ];

    /**
     * @param string|null $name
     *
     * @return Map
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }
}
