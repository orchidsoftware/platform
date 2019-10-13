<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;
use Illuminate\Support\Arr;

/**
 * Class ModalToggle.
 *
 * @method $this name(string $name = null)
 * @method $this modal(string $modalName = null)
 * @method $this icon(string $icon = null)
 * @method $this class(string $classes = null)
 * @method $this method(string $methodName = null)
 * @method $this parameters(array|object $name)
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
        'class'       => 'btn btn-link',
        'modal'       => null,
        'method'      => null,
        'async'       => false,
        'asyncParams' => [],
        'modalTitle'  => null,
        'icon'        => null,
        'action'      => null,
        'parameters'  => [],
    ];

    /**
     * Create instance of the button.
     *
     * @param string $name
     *
     * @return ModalToggle
     */
    public static function make(string $name = ''): ModalToggle
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
     * @param string       $modal
     * @param string       $method
     * @param string|array $options
     * @param string|null  $modalTitle
     *
     * @return ModalToggle
     */
    public function loadModalAsync(string $modal, string $method, $options = [], string $modalTitle = null): ModalToggle
    {
        $this->set('async');
        $this->set('modal', $modal);
        $this->set('method', $method);
        $this->set('asyncParams', Arr::wrap($options));
        $this->set('modalTitle', $modalTitle);

        return $this;
    }
}
