<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\Component as ViewComponent;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Component.
 */
abstract class Component extends Layout
{
    /**
     * @var string
     */
    private $component;

    /**
     * Component constructor.
     *
     * @param string $component
     */
    public function __construct(string $component)
    {
        $this->component = $component;
    }

    /**
     * @param Repository $repository
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        /** @var ViewComponent $component */
        $component = resolve($this->component, $repository->toArray());

        if (! $component->shouldRender()) {
            return;
        }

        $resolve = $component->resolveView();

        $view = is_string($resolve) ? view($resolve) : $resolve;

        return $view->with($component->data());
    }
}
