<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class DateTimer.
 *
 * @method self accept($value = true)
 * @method self accesskey($value = true)
 * @method self autocomplete($value = true)
 * @method self autofocus($value = true)
 * @method self checked($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self formaction($value = true)
 * @method self formenctype($value = true)
 * @method self formmethod($value = true)
 * @method self formnovalidate($value = true)
 * @method self formtarget($value = true)
 * @method self list($value = true)
 * @method self max(int $value)
 * @method self maxlength(int $value)
 * @method self min(int $value)
 * @method self multiple($value = true)
 * @method self name(string $value = null)
 * @method self pattern($value = true)
 * @method self placeholder(string $value = null)
 * @method self readonly($value = true)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self src($value = true)
 * @method self step($value = true)
 * @method self tabindex($value = true)
 * @method self value($value = true)
 * @method self help(string $value = null)
 * @method self popover(string $value = null)
 */
class DateTimer extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.datetime';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'type'                              => 'text',
        'class'                             => 'form-control',
        'data-fields--datetime-enable-time' => 'false',
        'data-fields--datetime-time-24hr'   => 'false',
        'data-fields--datetime-allow-input' => 'false',
        'data-fields--datetime-date-format' => 'Y-m-d H:i:S',
        'data-fields--datetime-no-calendar' => 'false',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
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
        'list',
        'max',
        'maxlength',
        'min',
        'multiple',
        'name',
        'pattern',
        'placeholder',
        'readonly',
        'required',
        'size',
        'src',
        'step',
        'tabindex',
        'value',
        'data-fields--datetime-enable-time',
        'data-fields--datetime-time-24hr',
        'data-fields--datetime-allow-input',
        'data-fields--datetime-date-format',
        'data-fields--datetime-no-calendar',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }

    /**
     * @param bool $time
     *
     * @return self
     */
    public function enableTime(bool $time = true) : self
    {
        $this->set('data-fields--datetime-enable-time', var_export($time, true));

        return $this;
    }

    /**
     * @param bool $time
     *
     * @return self
     */
    public function format24hr(bool $time = true) : self
    {
        $this->set('data-fields--datetime-time-24hr', var_export($time, true));

        return $this;
    }

    /**
     * @param bool $time
     *
     * @return self
     */
    public function allowInput(bool $time = true) : self
    {
        $this->set('data-fields--datetime-allow-input', var_export($time, true));

        return $this;
    }

    /**
     * @param string $format
     *
     * @return DateTimer
     */
    public function format(string  $format) : self
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
    public function noCalendar(bool $noCalendar = true) : self
    {
        $this->enableTime();
        $this->set('data-fields--datetime-no-calendar', var_export($noCalendar, true));

        return $this;
    }
}
