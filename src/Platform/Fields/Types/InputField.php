<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class InputField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.input';

    /**
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
