<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Support\Arr;
use Orchid\Screen\Action;

/**
 * Class ModalToggle.
 *
 * @method ModalToggle name(string $name = null)
 * @method ModalToggle modal(string $modalName = null)
 * @method ModalToggle icon(string $icon = null)
 * @method ModalToggle class(string $classes = null)
 * @method ModalToggle method(string $methodName = null)
 * @method ModalToggle parameters(array|object $name)
 * @method ModalToggle asyncParameters(array|object $parameters)
 * @method ModalToggle modalTitle(string $title)
 */
class ModalToggle extends Action
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
        'asyncParameters' => [],
        'parameters'      => [],
    ];

    /**
     * Create instance of the button.
     *
     * @param string $name
     *
     * @return ModalToggle
     */
    public static function make(string $name = ''): self
    {
        return (new static())
            ->name($name)
            ->addBeforeRender(function () use ($name) {
                $url = url()->current();
                $query = http_build_query($this->get('parameters'));

                $action = "{$url}/{$this->get('method')}?{$query}";
                $this->set('action', $action);
                $this->set('name', $name);
            });
    }

    /**
     * Call the modal with async method.
     * Options should contain values which handle by method.
     *
     * @deprecated It is necessary to form an asynchronous method manually
     *
     * @param string       $modal
     * @param string       $method
     * @param string|array $options
     * @param string|null  $modalTitle
     *
     * @return ModalToggle
     */
    public function loadModalAsync(string $modal, string $method, $options = [], string $modalTitle = null): self
    {
        return $this
            ->set('modal', $modal)
            ->set('method', $method)
            ->set('asyncParameters', Arr::wrap($options))
            ->set('modalTitle', $modalTitle);
    }
}
