<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class SelectField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.select';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
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
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'multiple',
        'name',
        'required',
        'size',
        'tabindex',
    ];
}
