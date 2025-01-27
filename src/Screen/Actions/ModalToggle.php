<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Support\Arr;

/**
 * Class ModalToggle.
 *
 * @method ModalToggle name(string $name = null)
 * @method ModalToggle icon(string $icon = null)
 * @method ModalToggle class(string $classes = null)
 * @method ModalToggle modalTitle(string $title)
 * @method ModalToggle async(bool $enabled = true)
 * @method ModalToggle open(bool $status = true)
 */
class ModalToggle extends Button
{
    protected string $view = 'platform::actions.modal';

    /**
     * Default attributes value.
     */
    protected array $attributes = [
        'class'      => 'btn btn-link icon-link',
        'modal'      => null,
        'method'     => null,
        'modalTitle' => null,
        'icon'       => null,
        'action'     => null,
        'async'      => false,
        'open'       => false,
        'parameters' => [],
    ];

    public function asyncParameters(array|int|string $options = []): Button
    {
        return $this
            ->parameters(Arr::wrap($options))
            ->set('async', 'true');
    }

    public function modal(string $name, array $options = []): static
    {
        $this->set('modal', $name);

        if (! empty($options)) {
            $this->asyncParameters($options);
        }

        return $this;
    }
}
