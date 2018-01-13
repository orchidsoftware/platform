<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class TextAreaField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.textarea';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class' => 'form-control no-resize',
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
}
