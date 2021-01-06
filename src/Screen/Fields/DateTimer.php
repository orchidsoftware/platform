<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class DateTimer.
 *
 * @method DateTimer accesskey($value = true)
 * @method DateTimer autofocus($value = true)
 * @method DateTimer disabled($value = true)
 * @method DateTimer form($value = true)
 * @method DateTimer formaction($value = true)
 * @method DateTimer formenctype($value = true)
 * @method DateTimer formmethod($value = true)
 * @method DateTimer formnovalidate($value = true)
 * @method DateTimer formtarget($value = true)
 * @method DateTimer name(string $value = null)
 * @method DateTimer placeholder(string $value = null)
 * @method DateTimer readonly($value = true)
 * @method DateTimer required(bool $value = true)
 * @method DateTimer tabindex($value = true)
 * @method DateTimer value($value = true)
 * @method DateTimer help(string $value = null)
 * @method DateTimer popover(string $value = null)
 * @method DateTimer allowEmpty(bool $enabled = true)
 * @method DateTimer title(string $value = null)
 */
class DateTimer extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.datetime';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'                                  => 'form-control',
        'data-fields--datetime-enable-time'      => 'false',
        'data-fields--datetime-time-24hr'        => 'false',
        'data-fields--datetime-allow-input'      => 'false',
        'data-fields--datetime-date-format'      => 'Y-m-d H:i:S',
        'data-fields--datetime-no-calendar'      => 'false',
        'data-fields--datetime-minute-increment' => 5,
        'data-fields--datetime-hour-increment'   => 1,
        'data-fields--datetime-static'           => 'false',
        'allowEmpty'                             => false,
        'placeholder'                            => 'Select Date...',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accept',
        'accesskey',
        'autocomplete',
        'autofocus',
        'checked',
        'disabled',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'name',
        'placeholder',
        'readonly',
        'required',
        'tabindex',
        'value',
        'data-fields--datetime-enable-time',
        'data-fields--datetime-time-24hr',
        'data-fields--datetime-allow-input',
        'data-fields--datetime-date-format',
        'data-fields--datetime-no-calendar',
    ];

    /**
     * Enables time picker.
     *
     * @param bool $time
     *
     * @return self
     */
    public function enableTime(bool $time = true): self
    {
        $this->set('data-fields--datetime-enable-time', var_export($time, true));

        return $this;
    }

    /**
     * Displays time picker in 24 hour mode without AM/PM selection when enabled.
     *
     * @param bool $time
     *
     * @return self
     */
    public function format24hr(bool $time = true): self
    {
        $this->set('data-fields--datetime-time-24hr', var_export($time, true));

        return $this;
    }

    /**
     * Allows the user to enter a date directly input the input field.
     * By default, direct entry is disabled.
     *
     * @param bool $time
     *
     * @return self
     */
    public function allowInput(bool $time = true): self
    {
        $this->set('data-fields--datetime-allow-input', var_export($time, true));

        return $this;
    }

    /**
     * A string of characters which are used
     * to define how the date will be displayed in the input box.
     *
     * @param string $format
     *
     * @return DateTimer
     */
    public function format(string $format): self
    {
        $this->set('data-fields--datetime-date-format', $format);

        return $this;
    }

    /**
     * Disable calendar for the field and show only time.
     *
     * @param bool $noCalendar
     *
     * @return $this
     */
    public function noCalendar(bool $noCalendar = true): self
    {
        $this->enableTime();
        $this->set('data-fields--datetime-no-calendar', var_export($noCalendar, true));

        return $this;
    }

    /**
     * Adjusts the step for the minute input (incl. scrolling).
     *
     * @param int $increment
     *
     * @return $this
     */
    public function minuteIncrement(int $increment)
    {
        $this->set('data-fields--datetime-minute-increment', $increment);

        return $this;
    }

    /**
     * Adjusts the step for the hour input (incl. scrolling).
     *
     * @param int $increment
     *
     * @return $this
     */
    public function hourIncrement(int $increment)
    {
        $this->set('data-fields--datetime-hour-increment', $increment);

        return $this;
    }
}
