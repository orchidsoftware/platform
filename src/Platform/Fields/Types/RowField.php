<?php

declare(strict_types=1);

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

/**
 * Class SelectField.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this multiple($value = true)
 * @method $this name($value = true)
 * @method $this required($value = true)
 * @method $this size($value = true)
 * @method $this tabindex($value = true)
 */
class RowField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.row';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
    ];

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
    ];
    
}
