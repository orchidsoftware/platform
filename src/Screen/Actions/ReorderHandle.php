<?php

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;

/**
 * @method ReorderHandle action(string $url)
 * @method ReorderHandle container(string $selector)
 * @method ReorderHandle icon(string $icon)
 * @method ReorderHandle key(string $key)
 * @method ReorderHandle successMessage(string $message)
 * @method ReorderHandle failureMessage(string $message)
 */
class ReorderHandle extends Action
{
    /**
     * View template show.
     *
     * @var string
     */
    protected $view = 'platform::actions.reorderHandle';

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    protected $attributes = [
        'action'         => null,
        'method'         => null,
        'icon'           => 'menu',
        'container'      => 'tbody',
        'successMessage' => null,
        'failureMessage' => null,
        'parameters'     => [],
    ];

    /**
     * Required Attributes.
     *
     * @var array
     */
    protected $required = [
        'key',
    ];

    public function __construct()
    {
        $this->addBeforeRender(function () {
            $this->set('action', $this->getAction());
            $this->set('class', $this->getClass());
        });
    }

    public function method(string $name, array $parameters = []): static
    {
        return $this
            ->set('method', $name)
            ->set('parameters', $parameters);
    }

    protected function getAction()
    {
        $action = $this->get('action');

        if ($action === null) {
            $url = request()->header('ORCHID-ASYNC-REFERER', url()->current());
            $query = http_build_query($this->get('parameters', []));
            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
        }

        return $action;
    }

    protected function getClass(): string
    {
        $classes = explode(' ', $this->get('class'));
        $classes[] = 'reorder-handle';

        return implode(' ', array_filter($classes));
    }
}
