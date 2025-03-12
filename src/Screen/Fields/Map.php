<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Map.
 *
 * @method static name(string $value = null)
 * @method static value($value = true)
 * @method static help(string $value = null)
 * @method static popover(string $value = null)
 * @method static zoom($value = true)
 * @method static height($value = '300px')
 * @method static title(string $value = null)
 * @method static required(bool $value = true)
 */
class Map extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.map';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'zoom'   => 14,
        'height' => '300px',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'name',
        'required',
        'height',
    ];
}
