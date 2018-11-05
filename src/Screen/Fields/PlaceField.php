<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class PlaceField.
 *
 * @method $this name($value = true)
 */
class PlaceField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.place';

    /**
     * @param null $name
     * @return PlaceField
     */
    public static function make($name = null): self
    {
        return (new static)->name($name);
    }
}
