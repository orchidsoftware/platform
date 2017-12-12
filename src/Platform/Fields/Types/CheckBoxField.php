<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class CheckBoxField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.checkbox';

    /**
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
