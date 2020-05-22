<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Quill.
 *
 * @method Quill autofocus($value = true)
 * @method Quill checked($value = true)
 * @method Quill disabled($value = true)
 * @method Quill form($value = true)
 * @method Quill formaction($value = true)
 * @method Quill formenctype($value = true)
 * @method Quill formmethod($value = true)
 * @method Quill formnovalidate($value = true)
 * @method Quill formtarget($value = true)
 * @method Quill name(string $value = null)
 * @method Quill placeholder(string $value = null)
 * @method Quill readonly($value = true)
 * @method Quill required(bool $value = true)
 * @method Quill tabindex($value = true)
 * @method Quill value($value = true)
 * @method Quill help(string $value = null)
 * @method Quill height($value = '300px')
 * @method Quill title(string $value = null)
 * @method Quill popover(string $value = null)
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
        'value'  => null,
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
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }
}
