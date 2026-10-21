<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class ViewField.
 *
 * @method $this name(string $value = null)
 * @method $this help(string $value = null)
 */
class ViewField extends Field
{
    /**
     * Set the Blade view used to render the field.
     */
    public function view(string $view): self
    {
        $this->view = $view;

        return $this;
    }
}
