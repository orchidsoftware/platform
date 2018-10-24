<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class LabelField.
 *
 * @method $this name($value = true)
 */
class LabelField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.label';
}
