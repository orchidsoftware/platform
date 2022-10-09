<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Field;

/**
 * Class NumberRange.
 *
 * @method NumberRange form($value = true)
 * @method NumberRange name(string $value = null)
 * @method NumberRange help(string $value = null)
 * @method NumberRange popover(string $value = null)
 * @method NumberRange title(string $value = null)
 */
class NumberRange extends Field implements ComplexFieldConcern
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.numberRange';

    protected $attributes = [
        'class'    => 'form-control',
        'type'     => 'number',
    ];
    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'form',
        'name',
        'class',
        'min',
        'max',
        'pattern',
        'readonly',
        'step',
        'type',
    ];
}
