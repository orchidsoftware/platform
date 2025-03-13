<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Concerns\ComplexFieldConcern;
use Orchid\Screen\Field;

/**
 * Class DateRange.
 *
 * @method $this form($value = true)
 * @method $this name(string $value = null)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
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

    /**
     * Disable native mobile pickers in favor of calendar
     *
     * @param bool $disable
     *
     * @return static
     */
    public function disableMobile(bool $disable = true): static
    {
        $this->set('data-datetime-disable-mobile', var_export($disable, true));

        return $this;
    }
}
