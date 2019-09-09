<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;
use Illuminate\Support\Arr;

/**
 * Class ModalToggle.
 *
 * @method self name(string $name = null)
 * @method self modal(string $modalName = null)
 * @method self icon(string $icon = null)
 * @method self class(string $classes = null)
 * @method self method(string $methodName = null)
 * @method self parameters(array|object $name)
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
        'class'       => 'btn btn-default dropdown-item',
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
     * @return self
     */
    public static function make(string $name): self
    {
        return (new static())->name($name)
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
    public function loadModalAsync(string $modal, string $method, $options = [], string $modalTitle = null): self
    {
        $this->set('async');
        $this->set('modal', $modal);
        $this->set('method', $method);
        $this->set('asyncParams', Arr::wrap($options));
        $this->set('modalTitle', $modalTitle);

        return $this;
    }
}
