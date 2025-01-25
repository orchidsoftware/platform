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

    /**
     * @param int|string|array $options
     * @return ModalToggle
     */
    public function asyncParameters(int|string|array $options = []): self
    {
        return $this
            ->parameters(Arr::wrap($options))
            ->set('async', 'true');
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return ModalToggle
     */
    public function modal(string $name, array $options = []): self
    {
        $this->set('modal', $name);

        if (! empty($options)) {
            $this->asyncParameters($options);
        }

        return $this;
    }
}
