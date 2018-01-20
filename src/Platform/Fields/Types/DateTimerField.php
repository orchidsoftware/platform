<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class DateTimerField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.datetime';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'type'  => 'text',
        'class' => 'form-control',
    ];

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
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
}
