<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;

/**
 * Class Button.
 *
 * @method Button name(string $name = null)
 * @method Button modal(string $modalName = null)
 * @method Button icon(string $icon = null)
 * @method Button class(string $classes = null)
 * @method Button method(string $methodName = null)
 * @method Button parameters(array|object $name)
 * @method Button novalidate(bool $novalidate = true)
 * @method Button confirm(string $confirm = true)
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
        'class'       => 'btn btn-link',
        'type'        => 'submit',
        'novalidate'  => false,
        'method'      => null,
        'icon'        => null,
        'action'      => null,
        'confirm'     => null,
        'parameters'  => [],
        'turbolinks'  => true,
    ];

    /**
     * Create instance of the button.
     *
     * @param string $name
     *
     * @return Button $name
     */
    public static function make(string $name = ''): self
    {
        return (new static())
            ->name($name)
            ->addBeforeRender(function () use ($name) {
                $url = url()->current();
                $query = http_build_query($this->get('parameters'));

                $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
                $this->set('action', $action);
                $this->set('name', $name);
            });
    }

    /**
     * Sets the URL form action to the address.
     * Always sending by the POST method.
     *
     * @param string $url
     *
     * @return Button
     */
    public function action(string $url): self
    {
        return $this->addBeforeRender(function () use ($url) {
            $this->set('action', $url);
        });
    }
}
