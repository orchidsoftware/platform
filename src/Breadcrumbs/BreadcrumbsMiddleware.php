<?php

declare(strict_types=1);

namespace Orchid\Breadcrumbs;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Opis\Closure\SerializableClosure;
use function Opis\Closure\unserialize;

class BreadcrumbsMiddleware
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var Manager
     */
    private $breadcrumbs;

    /**
     * BreadcrumbsMiddleware constructor.
     *
     * @param Router  $router
     * @param Manager $breadcrumbs
     */
    public function __construct(Router $router, Manager $breadcrumbs)
    {
        $this->router = $router;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @throws \Throwable
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        collect($this->router->getRoutes()->getIterator())
            ->filter(function (Route $route) {
                return array_key_exists(self::class, $route->defaults);
            })
            ->filter(function (Route $route) {
                return ! $this->breadcrumbs->has($route->getName());
            })
            ->each(function (Route $route) {
                $serialize = $route->defaults[self::class];

                // Check if a security provider was set
                if (null !== $securityProvider = SerializableClosure::getSecurityProvider()) {
                    // Don't worry about it, our closure will be executed locally
                    SerializableClosure::removeSecurityProvider();
                }

                /** @var \Opis\Closure\SerializableClosure $callback */
                $callback = unserialize($serialize);

                // Restore the security provider, if any
                if ($securityProvider !== null) {
                    SerializableClosure::addSecurityProvider($securityProvider);
                }

                if (is_a($callback, SerializableClosure::class)) {
                    $callback = $callback->getClosure();
                }

                $this->breadcrumbs->for($route->getName(), $callback);
            });

        optional($request->route())->forgetParameter(self::class);

        return $next($request);
    }
}
