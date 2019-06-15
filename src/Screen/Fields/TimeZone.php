<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use DateTimeZone;
use Orchid\Screen\Field;

/**
 * Class TimeZone.
 *
 * @method self autofocus($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self name(string $value = null)
 * @method self required(bool $value = true)
 * @method self tabindex($value = true)
 * @method self help(string $value = null)
 * @method self popover(string $value = null)
 */
class TimeZone extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.select';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'   => 'form-control',
        'options' => [],
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'multiple',
        'name',
        'required',
        'size',
        'tabindex',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null) : self
    {
        return (new static())->name($name)->listIdentifiers();
    }

    /**
     * @return self
     */
    public function multiple() : self
    {
        $this->attributes['multiple'] = 'multiple';

        return $this;
    }

    /**
     * @param int $time
     *
     * @return self
     */
    public function listIdentifiers($time = DateTimeZone::ALL) : self
    {
        $timeZone = collect(DateTimeZone::listIdentifiers($time))->mapWithKeys(function ($timezone) {
            return [$timezone => $timezone];
        })->toArray();

        $this->set('options', $timeZone);

        return $this;
    }
}
