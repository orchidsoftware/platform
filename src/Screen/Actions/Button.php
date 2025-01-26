<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;
use Orchid\Support\Facades\Dashboard;

/**
 * Class Button.
 *
 * @method Button name(string $name = null)
 * @method Button modal(string $modalName = null)
 * @method Button icon(string $icon = null)
 * @method Button class(string $classes = null)
 * @method Button confirm(string $confirm = true)
 * @method Button action(string $url)
 * @method Button disabled(bool $disabled = true)
 */
class Button extends Action
{

    protected string $view = 'platform::actions.button';

    /**
     * Default attributes value.
     */
    protected array $attributes = [
        'class'      => 'btn btn-link icon-link',
        'type'       => 'submit',
        'novalidate' => false,
        'method'     => null,
        'icon'       => null,
        'action'     => null,
        'confirm'    => null,
        'parameters' => [],
        'turbo'      => true,
        'form'       => 'post-form',
    ];

    /**
     * Attributes available for a particular tag.
     */
    protected array $inlineAttributes = [
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'type',
        'autofocus',
        'disabled',
        'tabindex',
    ];

    public function __construct()
    {
        $this->addBeforeRender(function () {
            if ($this->get('action') !== null) {
                return;
            }

            // correct URL for async request
            $url = Dashboard::isPartialRequest()
                ? url()->previous()
                : url()->current();

            $query = http_build_query($this->get('parameters'));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);
        })->addBeforeRender(function () {
            $action = $this->get('action');

            if ($action !== null) {
                $this->set('formaction', $action);
            }
        });
    }

    public function novalidate(bool $novalidate = true): static
    {
        return $this->set('formnovalidate', var_export($novalidate, true));
    }

    public function method(string $name, array $parameters = []): static
    {
        return $this
            ->set('method', $name)
            ->when(! empty($parameters), fn () => $this->parameters($parameters));
    }

    /**
     * Sets the parameters for the action.
     *
     * @param array|object $parameters The array or object containing the parameters.
     */
    public function parameters(array|object $parameters): static
    {
        $parameters = is_array($parameters)
            ? collect($parameters)->filter(fn ($value) => filled($value))->all()
            : $parameters;

        return $this->set('parameters', $parameters);
    }

    /**
     * Method download serves as an alias for the `rawClick` method.
     */
    public function download(bool $status = false): static
    {
        return $this->rawClick($status);
    }

    public function route(string $name, mixed $parameters = [], bool $absolute = true): static
    {
        return $this->action(route($name, $parameters, $absolute));
    }
}
