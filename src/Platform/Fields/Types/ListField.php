<?php
declare(strict_types=1);

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class ListField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.list';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
