<?php

declare(strict_types=1);

namespace Orchid\Breadcrumbs;

use Closure;
use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class Trail
{
    /**
     * The router.
     *
     * @var Registrar
     */
    protected $router;

    /**
     * The breadcrumb registrar.
     *
     * @var Registrar
     */
    protected $registrar;

    /**
     * The breadcrumb trail.
     *
     * @var Collection
     */
    protected $breadcrumbs;

    /**
     * Create a new instance of the generator.
     *
     * @param Router    $router
     * @param Registrar $registrar
     */
    public function __construct(Router $router, Registrar $registrar)
    {
        $this->router = $router;
        $this->registrar = $registrar;
        $this->breadcrumbs = new Collection;
    }

    /**
     * Register a definition with the registrar.
     *
     * @param string   $name
     * @param Closure $definition
     *
     * @return void
     * @throws \Throwable
     */
    public function register(string $name, Closure $definition)
    {
        $this->registrar->set($name, $definition);
    }

    /**
     * Generate the collection of breadcrumbs from the given route.
     *
     * @param array|null $parameters
     *
     * @return \Illuminate\Support\Collection
     * @throws \Throwable
     */
    public function generate(): Collection
    {
        $route = Route::current();

        if ($route && $this->registrar->has($route->getName())) {
            $this->call($route->getName(), $route->parameters());
        }

        return $this->breadcrumbs;
    }

    /**
     * Call a parent route with the given parameters.
     *
     * @param string $name
     * @param mixed  $parameters
     *
     * @return Trail
     * @throws \Throwable
     */
    public function parent(string $name, ...$parameters): Trail
    {
        $this->call($name, $parameters);

        return $this;
    }

    /**
     * Add a breadcrumb to the collection.
     *
     * @param  string  $title
     * @param  string  $url
     *
     * @return Trail
     */
    public function push(string $title, string $url = null): Trail
    {
        $this->breadcrumbs->push(new Crumb($title, $url));

        return $this;
    }

    /**
     * Call the breadcrumb definition with the given parameters.
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return void
     * @throws \Throwable
     */
    protected function call(string $name, array $parameters)
    {
        $definition = $this->registrar->get($name);

        $parameters = Arr::prepend(array_values($parameters), $this);

        call_user_func_array($definition, $parameters);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return $this->registrar->has($name);
    }
}
