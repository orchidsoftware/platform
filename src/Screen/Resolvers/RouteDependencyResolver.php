<?php

declare(strict_types=1);

namespace Orchid\Screen\Resolvers;

use Illuminate\Container\Container;
use Illuminate\Routing\ImplicitRouteBinding;
use Illuminate\Routing\RouteDependencyResolverTrait;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Screen;

class RouteDependencyResolver
{
    use RouteDependencyResolverTrait;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Screen $screen
     * @param string $method
     * @param array  $httpQueryArguments
     *
     * @return array
     */
    public function resolveScreen(Screen $screen, string $method, array $httpQueryArguments = []): array
    {
        if ($this->missingPublicMethod($screen, $method)) {
            return [];
        }

        $route = Route::current();

        if ($route === null) {
            return [];
        }

        collect($httpQueryArguments)
            ->except([])
            ->each(function ($value, $key) use ($route) {
                $route->setParameter($key, $value);
            });

        // This is normally handled in the "SubstituteBindings" middleware, but
        // because that middleware has already ran, we need to run them again.
        $this->container['router']->substituteImplicitBindings($route);

        // We'll set the route action to be from the parameter method from the chosen
        // Screen to get the proper implicit bindings.
        $route->uses(get_class($screen) . '@' . $method);

        ImplicitRouteBinding::resolveForRoute($this->container, Route::current());

        $parameters = $this->resolveClassMethodDependencies($route->parameters, $screen, $method);

        return collect($parameters)->except([
            'screen',
            'method',
            'template',
        ])->values()->all();
    }

    /**
     * @param \Orchid\Screen\Screen $screen
     * @param string                $method
     *
     * @return bool
     */
    protected function missingPublicMethod(Screen $screen, string $method): bool
    {
        $class = new \ReflectionClass($screen);

        return ! $class->hasMethod($method) || ! $class->getMethod($method)->isPublic();
    }
}
