<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields\Types;

use Orchid\Screen\Fields\Field;

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
}
