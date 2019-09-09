<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;

/**
 * Class Button.
 *
 * @method self name(string $name = null)
 * @method self modal(string $modalName = null)
 * @method self icon(string $icon = null)
 * @method self class(string $classes = null)
 * @method self method(string $methodName = null)
 * @method self parameters(array|object $name)
 * @method self novalidate(bool $novalidate = true)
 */
class Button extends Action
{
    /**
     * @var string
     */
    protected $view = 'platform::actions.button';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'       => 'btn btn-link dropdown-item',
        'novalidate'  => false,
        'method'      => null,
        'icon'        => null,
        'action'      => null,
        'parameters'  => [],
    ];

    /**
     * Create instance of the button.
     *
     * @param string $name
     *
     * @return Button $name
     */
    public static function make(string $name): self
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
}
