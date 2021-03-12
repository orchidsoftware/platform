<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Range
 *
 * @method Range accesskey($value = true)
 * @method Range autofocus($value = true)
 * @method Range disabled($value = true)
 * @method Range form($value = true)
 * @method Range name(string $value = null)
 * @method Range required(bool $value = true)
 * @method Range tabindex($value = true)
 * @method Range help(string $value = null)
 * @method Range popover(string $value = null)
 * @method Range title(string $value = null)
 * @method Range step($value = true)
 * @method Range max(int $value)
 * @method Range min(int $value)
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
