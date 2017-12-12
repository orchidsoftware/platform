<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class PictureField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.picture';

    /**
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
