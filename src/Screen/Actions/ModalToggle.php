<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
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
        'asyncParameters' => null,
        'async'           => false,
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

    /**
     * @deprecated
     *
     * @param string|int $slug
     *
     * @return ModalToggle
     */
    public function asyncParameter($slug): self
    {
        return $this->asyncParameters($slug);
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
