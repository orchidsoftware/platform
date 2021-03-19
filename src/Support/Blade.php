<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class Blade
{
    /**
     * @param string $class
     * @param mixed  $data
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return string|null
     */
    public static function renderComponent(string $class, $data): ?string
    {
        /** @var \Illuminate\View\Component $component */
        $component = is_array($data)
            ? resolve($class, $data)
            : new $class($data);

        if (! $component->shouldRender()) {
            return null;
        }

        $view = $component->resolveView();

        if ($view instanceof \Closure) {
            $view = $component->resolveView()($component->data());

            return view($view)->render();
        }

        if ($view instanceof View) {
            return $view->with($component->data())->render();
        }

        if ($view instanceof Htmlable) {
            return $view->toHtml();
        }

        return view($view)->with($component->data())->render();
    }
}
