<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class PlaceField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.place';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
