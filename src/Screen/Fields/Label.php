<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Label.
 *
 * @method $this name(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
 */
class Label extends Field
{
    /**
     * @var string
     */
    protected $view = 'orchid::fields.label';

    protected $attributes = [
        'id'    => null,
        'value' => null,
    ];

    protected $inlineAttributes = [
        'class',
    ];
}
