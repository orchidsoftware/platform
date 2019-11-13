<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class DateTimer.
 *
 * @method DateTimer accept($value = true)
 * @method DateTimer accesskey($value = true)
 * @method DateTimer autocomplete($value = true)
 * @method DateTimer autofocus($value = true)
 * @method DateTimer checked($value = true)
 * @method DateTimer disabled($value = true)
 * @method DateTimer form($value = true)
 * @method DateTimer formaction($value = true)
 * @method DateTimer formenctype($value = true)
 * @method DateTimer formmethod($value = true)
 * @method DateTimer formnovalidate($value = true)
 * @method DateTimer formtarget($value = true)
 * @method DateTimer list($value = true)
 * @method DateTimer max(int $value)
 * @method DateTimer maxlength(int $value)
 * @method DateTimer min(int $value)
 * @method DateTimer multiple($value = true)
 * @method DateTimer name(string $value = null)
 * @method DateTimer pattern($value = true)
 * @method DateTimer placeholder(string $value = null)
 * @method DateTimer readonly($value = true)
 * @method DateTimer required(bool $value = true)
 * @method DateTimer size($value = true)
 * @method DateTimer src($value = true)
 * @method DateTimer step($value = true)
 * @method DateTimer tabindex($value = true)
 * @method DateTimer value($value = true)
 * @method DateTimer help(string $value = null)
 * @method DateTimer popover(string $value = null)
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
        'type'                              => 'text',
        'class'                             => 'form-control',
        'data-fields--datetime-enable-time' => 'false',
        'data-fields--datetime-time-24hr'   => 'false',
        'data-fields--datetime-allow-input' => 'false',
        'data-fields--datetime-date-format' => 'Y-m-d H:i:S',
        'data-fields--datetime-no-calendar' => 'false',
        'allowEmpty'                        => false
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
    public function enableTime(bool $time = true): self
    {
        $this->set('data-fields--datetime-enable-time', var_export($time, true));

        return $this;
    }

    /**
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
     * @param bool $bool
     *
     * @return self
     */
    public function allowEmpty(bool $bool = true): self
    {
        $this->set('allowEmpty', $bool);

        if(true === $bool) {
            $this->addBeforeRender(function () {
                $this->attributes['class'] .= ' border-right-0';
            });
        }

        return $this;
    }

    /**
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
}
