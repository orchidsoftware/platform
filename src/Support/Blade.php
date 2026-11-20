<?php

declare(strict_types=1);

namespace Orchid\Support;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\View\AnonymousComponent;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Illuminate\View\Component as ViewComponent;
use Illuminate\View\ComponentSlot;

class Blade
{
    /**
     * Cached component class and view metadata indexed by component name.
     *
     * @var array<string, array{class-string<ViewComponent>, string|null}>
     */
    private static array $components = [];

    /**
     * Used to render a Blade component from a class and an array of data
     *
     * @throws BindingResolutionException
     */
    public static function renderComponent(string $class, mixed $data): ?string
    {
        $view = static::componentView($class, (array) $data);

        return $view instanceof View ? $view->render() : $view;
    }

    /**
     * Resolve the component's view with its bound data.
     *
     * @param array<array-key, mixed> $data
     */
    public static function componentView(string $class, array $data): View|string|null
    {
        $component = static::resolveComponent($class, $data);

        if (! $component->shouldRender()) {
            return null;
        }

        $data = $component->data();
        $data['slot'] ??= new ComponentSlot;
        $view = value($component->resolveView(), $data);

        if ($view instanceof View) {
            return $view->with($data);
        }

        return $view instanceof Htmlable ? $view->toHtml() : view()->make($view, $data);
    }

    /**
     * Get instance of the ViewComponent based on the provided class and data
     *
     * @throws BindingResolutionException
     */
    public static function resolveComponent(string $component, mixed $data): ViewComponent
    {
        [$class, $view] = static::componentInfo($component);

        if ($view !== null) {
            $data = ['view' => $view, 'data' => $data];
        }

        return resolve($class, $data);
    }

    /**
     * Get information about a component
     *
     * Response is array with two elements:
     *  0 - class name of component
     *  1 - view used only for anonymous components
     *
     * @return array{class-string<ViewComponent>, string|null}
     */
    public static function componentInfo(string $component): array
    {
        return self::$components[$component] ??= self::detectComponentInfo($component);
    }

    /**
     * Resolve the class and optional view used to render a Blade component.
     *
     * @return array{class-string<ViewComponent>, string|null}
     */
    private static function detectComponentInfo(string $component): array
    {
        if (is_subclass_of($component, ViewComponent::class)) {
            return [$component, null];
        }

        $view = self::compiler()->componentClass($component);

        return is_subclass_of($view, ViewComponent::class) ? [$view, null] : [AnonymousComponent::class, $view];
    }

    /**
     * Get an instance of the Blade tag compiler.
     */
    private static function compiler(): ComponentTagCompiler
    {
        return new ComponentTagCompiler(
            app('blade.compiler')->getClassComponentAliases(),
            app('blade.compiler')->getClassComponentNamespaces(),
            app('blade.compiler')
        );
    }
}
