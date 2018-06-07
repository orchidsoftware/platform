<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields\Types;

use Orchid\Screen\Fields\Field;

/**
 * Class LabelField.
 *
 * @method $this name($value = true)
 */
class LabelField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.label';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
