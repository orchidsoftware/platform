<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\View\AnonymousComponent;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Illuminate\View\Component as ViewComponent;

class Blade
{
    /**
     *
     * @var array
     */
    private static array $components = [];

    /**
     * The component tag compiler instance.
     *
     * @var ComponentTagCompiler
     */
    private static ComponentTagCompiler $compiler;

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
        $component = static::resolveComponent($class, (array)$data);

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

    public static function resolveComponent(string $component, $data): ViewComponent
    {
        [$class, $view] = static::componentInfo($component);

        if ($view !== null) {
            $data = ['view' => $view, 'data' => $data];
        }

        return resolve($class, $data);
    }

    /**
     * Get information about component
     *
     * Response is array with two elements:
     *  0 - class name of component
     *  1 - view used only for anonymous components
     *
     * @param string $component
     *
     * @return array
     */
    public static function componentInfo(string $component): array
    {
        return static::$components[$component] ??= static::detectComponentInfo($component);
    }

    private static function detectComponentInfo(string $component): array
    {
        if (is_subclass_of($component, ViewComponent::class)) {
            return [$component, null];
        }

        $view = static::compiler()->componentClass($component);

        return is_subclass_of($view, ViewComponent::class) ? [$view, null] : [AnonymousComponent::class, $view];
    }

    /**
     * Get an instance of the Blade tag compiler.
     *
     * @return ComponentTagCompiler
     */
    private static function compiler(): ComponentTagCompiler
    {
        return static::$compiler ??= new ComponentTagCompiler(
            app('blade.compiler')->getClassComponentAliases(),
            app('blade.compiler')->getClassComponentNamespaces(),
            app('blade.compiler')
        );
    }
}
