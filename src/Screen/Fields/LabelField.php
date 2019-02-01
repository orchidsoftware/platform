<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class LabelField.
 *
 * @method $this name(string $value)
 * @method $this popover(string $value = null)
 */
class LabelField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.label';

    /**
     * @param string|null $name
     * @return LabelField
     */
    public static function make(string $name = null): self
    {
        return (new static)->name($name);
    }
}
