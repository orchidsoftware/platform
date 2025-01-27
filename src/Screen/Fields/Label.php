<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Label.
 *
 * @method Label name(string $value = null)
 * @method Label popover(string $value = null)
 * @method Label title(string $value = null)
 */
class Label extends Field
{

    protected string $view = 'platform::fields.label';

    /**
     * Default attributes value.
     */
    protected array $attributes = [
        'id'    => null,
        'value' => null,
    ];

    /**
     * Attributes available for a particular tag.
     */
    protected array $inlineAttributes = [
        'class',
    ];
}
