<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Carbon\Carbon;
use Orchid\Screen\Field;

/**
 * Class DateTimer.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this formaction($value = true)
 * @method $this formenctype($value = true)
 * @method $this formmethod($value = true)
 * @method $this formnovalidate($value = true)
 * @method $this formtarget($value = true)
 * @method $this name(string $value = null)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required(bool $value = true)
 * @method $this tabindex($value = true)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this allowEmpty(bool $enabled = true)
 * @method $this title(string $value = null)
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
        'class'                                 => 'form-control',
        'data-datetime-enable-time'             => 'false',
        'data-datetime-time_24hr'               => 'false',
        'data-datetime-allow-input'             => 'false',
        'data-datetime-date-format'             => 'Y-m-d H:i:S',
        'data-datetime-no-calendar'             => 'false',
        'data-datetime-minute-increment'        => 5,
        'data-datetime-hour-increment'          => 1,
        'data-datetime-static'                  => 'false',
        'data-datetime-disable-mobile'          => 'false',
        'data-datetime-inline'                  => 'false',
        'data-datetime-position'                => 'auto auto',
        'data-datetime-shorthand-current-month' => 'false',
        'data-datetime-alt-input'               => 'false',
        'data-datetime-show-months'             => 1,
        'allowEmpty'                            => false,
        'placeholder'                           => 'Select Date...',
        'quickDates'                            => [],
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
        'data-datetime-enable-time',
        'data-datetime-time_24hr',
        'data-datetime-allow-input',
        'data-datetime-date-format',
        'data-datetime-no-calendar',
        'data-datetime-enable',
        'data-datetime-disable',
        'data-datetime-max-date',
        'data-datetime-min-date',
        'data-datetime-disable-mobile',
        'data-datetime-inline',
        'data-datetime-position',
        'data-datetime-shorthand-current-month',
        'data-datetime-show-months',
        'data-datetime-alt-input',
        'data-datetime-alt-format',
    ];

    /**
     * Enables time picker.
     */
    public function enableTime(bool $time = true): static
    {
        $this->set('data-datetime-enable-time', var_export($time, true));

        return $this;
    }

    /**
     * Displays time picker in 24-hour mode without AM/PM selection when enabled.
     */
    public function format24hr(bool $time = true): static
    {
        $this->set('data-datetime-time_24hr', var_export($time, true));

        return $this;
    }

    /**
     * Allows the user to enter a date directly input the input field.
     * By default, direct entry is disabled.
     */
    public function allowInput(bool $time = true): static
    {
        $this->set('data-datetime-allow-input', var_export($time, true));

        return $this;
    }

    /**
     * A string of characters which are used
     * to define how the date will be displayed in the input box.
     */
    public function format(string $format): static
    {
        $this->set('data-datetime-date-format', $format);

        return $this;
    }

    /**
     * Sets format for transmission to the front values
     * If the argument is not passed, then the value specified
     * in the 'format' method will be taken
     *
     * @param string|null $format
     *
     * @return static
     */
    public function serverFormat(?string $format = null): static
    {
        return $this->addBeforeRender(function () use ($format) {
            $value = $this->get('value');

            if ($value === null) {
                return;
            }

            if ($format === null) {
                $format = $this->get('data-datetime-date-format');
            }

            $this->set('value', Carbon::parse($value)->format($format));
        });
    }

    /**
     * Disable the calendar for the field and show only time.
     *
     * @param bool $noCalendar
     *
     * @return static
     */
    public function noCalendar(bool $noCalendar = true): static
    {
        $this->enableTime();
        $this->set('data-datetime-no-calendar', var_export($noCalendar, true));

        return $this;
    }

    /**
     * Adjusts the step for the minute input (incl. scrolling).
     *
     * @param int $increment
     *
     * @return static
     */
    public function minuteIncrement(int $increment): static
    {
        $this->set('data-datetime-minute-increment', $increment);

        return $this;
    }

    /**
     * Adjusts the step for the hour input (incl. scrolling).
     *
     * @param int $increment
     *
     * @return static
     */
    public function hourIncrement(int $increment): static
    {
        $this->set('data-datetime-hour-increment', $increment);

        return $this;
    }

    /**
     * Enable a specific set of dates for selection
     *
     * ['2021-04-27', '2021-04-20']
     *
     * or ranges
     *
     * [
     *     ['from' => '2021-04-04', 'to' => '2021-04-10'],
     *     ['from' => '2021-04-25', 'to' => '2021-05-01'],
     *
     * ]
     *
     *
     * @param array $dates
     *
     * @return static
     */
    public function available(array $dates = []): static
    {
        $this->set('data-datetime-enable', json_encode($dates));

        return $this;
    }

    /**
     * Disable specific set of dates for selection
     *
     * ['2021-04-27', '2021-04-20']
     *
     * or ranges
     *
     * [
     *     ['from' => '2021-04-04', 'to' => '2021-04-10'],
     *     ['from' => '2021-04-25', 'to' => '2021-05-01'],
     *
     * ]
     *
     *
     * @param array $dates
     *
     * @return static
     */
    public function unavailable(array $dates = []): static
    {
        $this->set('data-datetime-disable', json_encode($dates));

        return $this;
    }

    /**
     * Allow selection of dates on or before the specified date
     *
     * @param \Carbon\Carbon $date
     *
     * @return static
     */
    public function max(Carbon $date): static
    {
        $format = $this->get('data-datetime-date-format');
        $this->set('data-datetime-max-date', $date->format($format));

        return $this;
    }

    /**
     * Allow selection of dates on or after the specified date
     *
     * @param \Carbon\Carbon $date
     *
     * @return static
     */
    public function min(Carbon $date): static
    {
        $format = $this->get('data-datetime-date-format');
        $this->set('data-datetime-min-date', $date->format($format));

        return $this;
    }

    /**
     * Show calendar week numbers
     *
     * @param bool $show
     *
     * @return static
     */
    public function weekNumbers(bool $show = true): static
    {
        $this->set('data-datetime-week-numbers', var_export($show, true));

        return $this;
    }

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
     * Disable native mobile pickers in favor of calendar
     *
     * @param bool $inline
     *
     * @return static
     */
    public function inline(bool $inline = true): static
    {
        $this->set('class', 'd-none');
        $this->set('data-datetime-inline', var_export($inline, true));

        return $this;
    }

    /**
     * @param bool $static
     *
     * @return static
     */
    public function static(bool $static = true): static
    {
        $this->set('data-datetime-static', var_export($static, true));

        return $this;
    }

    /**
     * Show the month using the shorthand version (ie, Sep instead of September).
     *
     * @param bool $short
     *
     * @return static
     */
    public function shorthandCurrentMonth(bool $short = true): static
    {
        $this->set('data-datetime-shorthand-current-month', var_export($short, true));

        return $this;
    }

    /**
     * The number of months to be shown at the same time when displaying the calendar.
     *
     * @param int $count
     *
     * @return static
     */
    public function showMonths(int $count = 1): static
    {
        $this->set('data-datetime-show-months', $count);

        return $this;
    }

    /**
     * Where the calendar is rendered relative to the input vertically and horizontally.
     * In the format of "[vertical] [horizontal]". Vertical can be auto, above or below (required).
     * Horizontal can be left, center or right.
     *
     *  E.g. "above" or "auto center"
     *
     * Not used with inline()
     *
     * @param string $vertical
     * @param string $horizontal
     *
     * @return static
     */
    public function position(string $vertical = 'auto', string $horizontal = 'auto'): static
    {
        $this->set('data-datetime-position', $vertical.' '.$horizontal);

        return $this;
    }

    /**
     * @return static
     */
    public function range(): static
    {
        $this->set('data-datetime-mode', 'range');

        return $this;
    }

    public function multiple(): static
    {
        $this->set('data-datetime-mode', 'multiple')
            ->addBeforeRender(function () {
                $this->set('data-datetime-default-date', json_encode($this->attributes['value']));
                $this->attributes['value'] = null;
            });

        return $this;
    }

    /**
     * Set quick date options for selection near an input field.
     *
     * @param array $presets An array of preset date values
     *
     * @return static
     */
    public function withQuickDates(array $presets): static
    {
        $formattedPresets = collect($presets)
            ->map(fn ($value) => collect($value))
            ->map
            ->map(fn ($value) => Carbon::parse($value)->format($this->attributes['data-datetime-date-format']))
            ->all();

        $this->attributes['quickDates'] = $formattedPresets;

        return $this;
    }

    /**
     * Set the date format for the alt input field.
     *
     * @param string $format
     *
     * @return static
     */
    public function altFormat(string $format): static
    {
        $this->set('data-datetime-alt-format', $format);
        $this->set('data-datetime-alt-input', var_export(true, true));

        return $this;
    }
}
