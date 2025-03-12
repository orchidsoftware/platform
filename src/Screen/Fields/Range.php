<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Range
 *
* @method static accesskey($value = true)
* @method static autofocus($value = true)
* @method static disabled($value = true)
* @method static form($value = true)
* @method static name(string $value = null)
* @method static required(bool $value = true)
* @method static tabindex($value = true)
* @method static help(string $value = null)
* @method static popover(string $value = null)
* @method static title(string $value = null)
* @method static step($value = true)
* @method static max(int $value)
* @method static min(int $value)
 */
class Range extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.range';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'name',
        'required',
        'size',
        'tabindex',
        'type',
        'step',
        'max',
        'min',
    ];
}
