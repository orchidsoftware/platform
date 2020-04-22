<?php

declare(strict_types=1);

namespace Orchid\Breadcrumbs;

use Closure;
use Exception;

class Registrar
{
    /**
     * Breadcrumb definitions.
     *
     * @var array
     */
    protected $definitions = [];

    /**
     * Get a definition for a route name.
     *
     * @param string $name
     *
     * @return \Closure
     * @throws \Throwable
     */
    public function get(string $name): Closure
    {
        throw_unless($this->has($name),
            Exception::class,
            "No breadcrumbs defined for route [{$name}].");

        return $this->definitions[$name];
    }

    /**
     * Return whether a definition exists for a route name
     *
     * @param  string  $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->definitions);
    }

    /**
     * Set the registration for a route name.
     *
     * @param string   $name
     * @param \Closure $definition
     *
     * @return void
     * @throws \Throwable
     */
    public function set(string $name, Closure $definition): void
    {
        throw_if($this->has($name),
            Exception::class,
            "Breadcrumbs have already been defined for route [{$name}].");

        $this->definitions[$name] = $definition;
    }
}
