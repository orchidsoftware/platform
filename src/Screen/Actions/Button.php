<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Contracts\Routing\UrlRoutable;
use Orchid\Screen\Action;
use Orchid\Screen\Field;
use Orchid\Support\Facades\Orchid;

/**
 * Class Button.
 *
 * @method $this name(string $name = null)
 * @method $this modal(string $modalName = null)
 * @method $this icon(string $icon = null)
 * @method $this class(string $classes = null)
 * @method $this confirm(string $confirm = true)
 * @method $this action(string $url)
 * @method $this disabled(bool $disabled = true)
 */
class Button extends Action
{
    /**
     * @var string
     */
    protected $view = 'orchid::actions.button';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'      => 'btn btn-link icon-link gap-2',
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
     *
     * @var array
     */
    protected $inlineAttributes = [
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

    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     *
     * @var array
     */
    protected $translations = [
        'name',
        'confirm',
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

            // correct URL for async request
            $url = Orchid::isPartialRequest()
                ? url()->previous()
                : url()->current();

            // url()->previous() can carry the query string of the page it was
            // requested from (e.g. active filters/sorts, or a paginated
            // ?page=2 listing). Appending the method name straight after that
            // query string splices it into the middle of the URL and breaks
            // routing (`.../all?page=2/setImage`, see #2845), so the path and
            // query need to be separated before the method is appended.
            // The previous query string itself is kept and merged behind the
            // method, rather than discarded, so things like table filters
            // still apply to the action (e.g. an Export button still
            // respects the filters selected on the listing, see #3150).
            $path = strtok($url, '?');
            parse_str((string) parse_url($url, PHP_URL_QUERY), $previousQuery);

            $parameters = $this->get('parameters');
            $query = http_build_query(array_merge($previousQuery, is_array($parameters) ? $parameters : (array) $parameters));

            $action = rtrim("{$path}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);
        })->addBeforeRender(function () {
            $action = $this->get('action');

            if ($action !== null) {
                $this->set('formaction', $action);
            }
        });
    }

    /**
     * @return Button|Field
     */
    public function novalidate(bool $novalidate = true): static
    {
        return $this->set('formnovalidate', var_export($novalidate, true));
    }

    /**
     * @return $this
     */
    public function method(string $name, array $parameters = []): static
    {
        return $this
            ->set('method', $name)
            ->when(! empty($parameters), fn () => $this->parameters($parameters));
    }

    /**
     * Sets the parameters for the action.
     *
     * @param array|object $parameters
     *
     * @return $this
     */
    public function parameters(array|object $parameters): static
    {
        return $this->set('parameters', $this->prepareActionParameters($parameters));
    }

    /**
     * Normalizes parameters before setting them.
     *
     * @param array|object $parameters
     *
     * @return array|object
     */
    protected function prepareActionParameters(array|object $parameters): array|object
    {
        if (! is_array($parameters)) {
            return $parameters;
        }

        return collect($parameters)
            ->filter(fn ($value) => filled($value))
            ->map(fn ($value) => $this->extractRouteKey($value))
            ->all();
    }

    /**
     * Extracts key from Eloquent model if applicable.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function extractRouteKey(mixed $value): mixed
    {
        return $value instanceof UrlRoutable ? $value->getRouteKey() : $value;
    }

    /**
     * Method download serves as an alias for the `rawClick` method.
     */
    public function download(bool $status = false): static
    {
        return $this->rawClick($status);
    }

    /**
     * @param array|string $name
     * @param mixed        $parameters
     * @param bool         $absolute
     *
     * @return static
     */
    public function route($name, $parameters = [], $absolute = true): static
    {
        return $this->action(route($name, $parameters, $absolute));
    }
}
