<?php

declare(strict_types=1);

namespace Orchid\Breadcrumbs;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class Manager
{
    /**
     * The breadcrumb generator.
     *
     * @var Trail
     */
    protected $generator;

    /**
     * Create the instance of the manager.
     *
     * @param Trail $generator
     *
     * @return void
     */
    public function __construct(Trail $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Register a breadcrumb definition by passing it off to the registrar.
     *
     * @param string   $route
     * @param \Closure $definition
     *
     * @return void
     * @throws \Throwable
     */
    public function for(string $route, Closure $definition)
    {
        $this->generator->register($route, $definition);
    }

    /**
     * Render the breadcrumbs as an HTML string
     *
     * @param array $parameters
     *
     * @return Collection
     * @throws \Throwable
     */
    public function render($parameters = null): Collection
    {
        $parameters = Arr::wrap($parameters);

        return $this->generator->generate($parameters);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name = null): bool
    {
        $name = $name ?? Route::currentRouteName();

        if ($name === null) {
            return false;
        }

        return $this->generator->has($name);
    }
}
