<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class RelationshipField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.relationship';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
        'handler',
    ];
}
