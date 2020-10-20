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
 * @method Button action(string $url)
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
     * Button constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            if ($this->get('action') !== null) {
                return;
            }

            $url = url()->current();
            $query = http_build_query($this->get('parameters'));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);
        });
    }
}
