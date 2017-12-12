<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class LabelField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.label';

    /**
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
