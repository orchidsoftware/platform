<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class TextArea.
 *
* @method static accesskey($value = true)
* @method static autofocus($value = true)
* @method static cols($value = true)
* @method static disabled($value = true)
* @method static form($value = true)
* @method static maxlength(int $value)
* @method static name(string $value = null)
* @method static placeholder(string $value = null)
* @method static readonly($value = true)
* @method static required(bool $value = true)
* @method static rows(int $value)
* @method static tabindex($value = true)
* @method static wrap($value = true)
* @method static help(string $value = null)
* @method static max(int $value)
* @method static popover(string $value = null)
* @method static title(string $value = null)
 */
class TextArea extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.textarea';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class' => 'form-control no-resize',
        'value' => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
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
}
