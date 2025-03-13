<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Map.
 *
 * @method $this name(string $value = null)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this zoom($value = true)
 * @method $this height($value = '300px')
 * @method $this title(string $value = null)
 * @method $this required(bool $value = true)
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
