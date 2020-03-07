<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\Component as ViewComponent;
use Orchid\Screen\Repository;

/**
 * Class Component.
 */
abstract class Component extends Base
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
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function build(Repository $repository)
    {
        if (!$this->checkPermission($this, $repository)) {
            return;
        }

        /** @var ViewComponent $component */
        $component = app()->make($this->component, $repository->toArray());

        if (!$component->shouldRender()) {
            return;
        }

        $resolve = $component->resolveView();

        $view = is_string($resolve) ? view($resolve) : $resolve;

        return $view->with($component->data());
    }
}
