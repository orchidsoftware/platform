<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Label.
 *
 * @method static name(string $value = null)
 * @method static popover(string $value = null)
 * @method static title(string $value = null)
 */
class Label extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.label';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'id'    => null,
        'value' => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'class',
    ];
}
