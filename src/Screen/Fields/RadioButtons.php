<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class RadioButtons.
 *
 * @method self accesskey($value = true)
 * @method self autofocus($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self name(string $value)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self tabindex($value = true)
 * @method self help(string $value = null)
 * @method self popover(string $value = null)
 */
class RadioButtons extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.radiobutton';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'type' => 'radio',
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
        'type',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static)->name($name);
    }
}
