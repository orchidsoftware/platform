<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class TextArea.
 *
 * @method TextArea accesskey($value = true)
 * @method TextArea autofocus($value = true)
 * @method TextArea cols($value = true)
 * @method TextArea disabled($value = true)
 * @method TextArea form($value = true)
 * @method TextArea maxlength(int $value)
 * @method TextArea name(string $value = null)
 * @method TextArea placeholder(string $value = null)
 * @method TextArea readonly($value = true)
 * @method TextArea required(bool $value = true)
 * @method TextArea rows(int $value)
 * @method TextArea tabindex($value = true)
 * @method TextArea wrap($value = true)
 * @method TextArea help(string $value = null)
 * @method TextArea max(int $value)
 * @method TextArea popover(string $value = null)
 * @method TextArea title(string $value = null)
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
