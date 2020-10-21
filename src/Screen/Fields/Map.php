<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Map.
 *
 * @method Map name(string $value = null)
 * @method Map value($value = true)
 * @method Map help(string $value = null)
 * @method Map popover(string $value = null)
 * @method Map zoom($value = true)
 * @method Map height($value = '300px')
 * @method Map title(string $value = null)
 * @method Map required(bool $value = true)
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
