<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

/**
 * Class ModalToggle.
 *
 * @method ModalToggle name(string $name = null)
 * @method ModalToggle modal(string $modalName = null)
 * @method ModalToggle icon(string $icon = null)
 * @method ModalToggle class(string $classes = null)
 * @method ModalToggle method(string $methodName = null)
 * @method ModalToggle parameters(array|object $name)
 * @method ModalToggle modalTitle(string $title)
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
        'class'           => 'btn btn-link',
        'modal'           => null,
        'method'          => null,
        'modalTitle'      => null,
        'icon'            => null,
        'action'          => null,
        'asyncParameters' => null,
        'async'           => false,
        'parameters'      => [],
    ];

    /**
     * @param int|string|array $options
     *
     * @return ModalToggle
     */
    public function asyncParameters($options = []): self
    {
        return $this
            ->set('asyncParameters', Arr::wrap($options))
            ->set('async', 'true')
            ->addBeforeRender(function () use ($options) {
                $method = $this->get('method');
                $action = route(Route::currentRouteName(), $options);
                $this->set('action', $action.'/'.$method);
            });
    }
}
