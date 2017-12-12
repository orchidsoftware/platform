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
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
