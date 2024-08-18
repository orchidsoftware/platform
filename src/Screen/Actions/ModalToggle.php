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
    /**
     * @var string
     */
    protected $view = 'platform::actions.modal';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
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
     */
    public function asyncParameters($options = []): self
    {
        return $this
            ->parameters(Arr::wrap($options))
            ->set('async', 'true');
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return $this|\Orchid\Screen\Actions\Button
     */
    public function modal(string $name, array $options = [])
    {
        $this->set('modal', $name);

        if (! empty($options)) {
            $this->asyncParameters($options);
        }

        return $this;
    }
}
