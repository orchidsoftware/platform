<?php

declare(strict_types=1);

namespace Orchid\Support\Testing;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;

class DynamicTestScreen
{
    /**
     * @var MakesHttpRequestsWrapper
     */
    protected $http;

    /**
     * Route name
     *
     * @var string
     */
    protected $name;

    /**
     * Route parameters
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $session = [];

    /**
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        $this->http = app(MakesHttpRequestsWrapper::class);
        $this->name = $name ?? Str::uuid()->toString();
    }

    /**
     * Declarate dinamic route
     *
     * @param string       $screen
     * @param string|null  $route
     * @param string|array $middleware
     *
     * @return DynamicTestScreen
     */
    public function register(string $screen, string $route = null, $middleware = 'web'): DynamicTestScreen
    {
        Route::screen('/_test/' . ($route ?? $this->name), $screen)
            ->middleware($middleware)
            ->name($this->name);

        Route::getRoutes()->refreshNameLookups();
        Route::getRoutes()->refreshActionLookups();

        return $this;
    }

    /**
     * Set Route Parameters
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function parameters(array $parameters = []): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set the session to the given array.
     *
     * @param array $data
     *
     * @return $this
     */
    public function session(array $data): DynamicTestScreen
    {
        $this->session = $data;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \Illuminate\Testing\TestResponse|mixed
     */
    public function display(array $headers = [])
    {
        return $this->http->get($this->route(), $headers);
    }

    /**
     * Call screen method
     *
     * @param string $method
     * @param array  $parameters
     * @param array  $headers
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function method(string $method, array $parameters = [], array $headers = []): TestResponse
    {
        $route = $this->route(array_merge(
            $this->parameters,
            ['method' => $method,]
        ));

        $this->from($route);

        return $this->http
            ->withSession($this->session)
            ->followingRedirects()
            ->post($route, $parameters, $headers);
    }

    /**
     * The alias for the "method"
     *
     * @param string $method
     * @param array  $parameters
     * @param array  $headers
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function call(string $method, array $parameters = [], array $headers = []): TestResponse
    {
        return $this->method($method, $parameters, $headers);
    }

    /**
     * Get route URL
     *
     * @param array|null $parameters
     *
     * @return string
     */
    protected function route(array $parameters = null): string
    {
        return route($this->name, $parameters ?? $this->parameters);
    }

    /**
     * Set the currently logged-in user for the application.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string|null                                $guard
     *
     * @return $this
     */
    public function actingAs(UserContract $user, $guard = null): self
    {
        $this->be($user, $guard);

        return $this;
    }

    /**
     * Set the currently logged-in user for the application.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string|null                                $guard
     *
     * @return $this
     */
    public function be(UserContract $user, $guard = null): self
    {
        $this->http->be($user, $guard);

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $arguments
     *
     * @return $this
     */
    public function __call(string $name, $arguments)
    {
        $this->http->$name($arguments);

        return $this;
    }

    /**
     * Set the URL of the previous request.
     *
     * @param string $url
     *
     * @return $this
     */
    public function from(string $url): self
    {
        $this->http->getAppication()['session']->setPreviousUrl($url);

        return $this;
    }
}
