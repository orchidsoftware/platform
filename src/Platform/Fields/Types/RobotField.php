<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class RobotField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.robot';

    /**
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
