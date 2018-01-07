<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class CodeField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.code';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
