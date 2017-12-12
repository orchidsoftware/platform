<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class TinyMCEField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.tinymce';

    /**
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
