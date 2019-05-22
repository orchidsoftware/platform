<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class TextArea.
 *
 * @method self accesskey($value = true)
 * @method self autofocus($value = true)
 * @method self cols($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self maxlength(int $value)
 * @method self name(string $value = null)
 * @method self placeholder(string $value = null)
 * @method self readonly($value = true)
 * @method self required(bool $value = true)
 * @method self rows(int $value)
 * @method self tabindex($value = true)
 * @method self wrap($value = true)
 * @method self help(string $value = null)
 * @method self max(int $value)
 * @method self popover(string $value = null)
 */
class TextArea extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.textarea';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class' => 'form-control no-resize',
        'value' => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accesskey',
        'autofocus',
        'cols',
        'disabled',
        'form',
        'maxlength',
        'name',
        'placeholder',
        'readonly',
        'required',
        'rows',
        'tabindex',
        'wrap',
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
