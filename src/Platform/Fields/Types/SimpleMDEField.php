<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class SimpleMDEField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.simplemde';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
