<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Support\Carbon;
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
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'data-datetime-date-format' => 'Y-m-d H:i:S',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'form',
        'name',
        'data-datetime-date-format',
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

    /**
     * A string of characters which are used
     * to define how the date will be displayed in the input box.
     */
    public function format(string $format): self
    {
        $this->set('data-datetime-date-format', $format);

        return $this;
    }

    /**
     * Sets format for transmission to the front values
     * If the argument is not passed, then the value specified
     * in the 'format' method will be taken
     *
     *
     * @return $this
     */
    public function serverFormat(?string $format = null): self
    {
        return $this->addBeforeRender(function () use ($format) {
            $values = $this->get('value');

            if ($values === null || (is_array($values) && count($values) === 0)) {
                return;
            }

            if ($format === null) {
                $format = $this->get('data-datetime-date-format');
            }

            foreach ($values as $key => $value) {

                if ($value === null) {
                    continue;
                }

                $values[$key] = Carbon::parse($value)->format($format);
            }

            $this->set('value', $values);
        });
    }
}
