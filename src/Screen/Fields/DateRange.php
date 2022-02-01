<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Field;

/**
 * Class DateRange.
 *
 * @method DateRange form($value = true)
 * @method DateRange name(string $value = null)
 * @method DateRange value($value = true)
 * @method DateRange help(string $value = null)
 * @method DateRange popover(string $value = null)
 * @method DateRange title(string $value = null)
 */
class DateRange extends Field implements ComplexFieldConcern
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.dataRange';

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'form',
        'name',
    ];
}
