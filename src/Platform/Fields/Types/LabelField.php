<?php

declare(strict_types=1);

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

/**
 * Class LabelField.
 * @method $this name($value = true)
 */
class LabelField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.label';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
