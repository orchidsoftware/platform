<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class TextArea.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this cols($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this maxlength(int $value)
 * @method $this name(string $value = null)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required(bool $value = true)
 * @method $this rows(int $value)
 * @method $this tabindex($value = true)
 * @method $this wrap($value = true)
 * @method $this help(string $value = null)
 * @method $this max(int $value)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
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
