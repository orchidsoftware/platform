<?php

declare(strict_types=1);

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

/**
 * Class PlaceField
 * @method $this name($value = true)
 */
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
