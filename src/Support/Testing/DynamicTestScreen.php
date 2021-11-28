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
     * @var
     */
    protected $parameters;

    /**
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        $this->http = app(MakesHttpRequestsWrapper::class);
        $this->name = $name;
    }

    /**
     * Declarate dinamic route
     *
     * @param string      $screen
     * @param string|null $route
     * @param string      $middleware
     *
     * @return DynamicTestScreen
     */
    public function register(string $screen, string $route = null, $middleware = 'web')
    {
        $this->name = Str::uuid()->toString();

        Route::screen('/_test/'.$route ?? $this->name, $screen)
            ->middleware($middleware)
            ->name($this->name);

        Route::getRoutes()->refreshNameLookups();
        Route::getRoutes()->refreshActionLookups();

        return $this;
    }

    /**
     * Set Route Parameters
     *
     * @param mixed $parameters
     *
     * @return $this
     */
    public function parameters($parameters = [])
    {
        $this->parameters = $parameters;

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
        $route = $this->route();
        $this->from($route);

        return $this->http
            ->followingRedirects()
            ->post($route, array_merge($parameters, [
                'method' => $method,
            ]), $headers);
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
     * @return string
     */
    protected function route()
    {
        return route($this->name, $this->parameters);
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string|null                                $guard
     *
     * @return $this
     */
    public function actingAs(UserContract $user, $guard = null)
    {
        $this->be($user, $guard);

        return $this;
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string|null                                $guard
     *
     * @return $this
     */
    public function be(UserContract $user, $guard = null)
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
    public function from(string $url)
    {
        $this->http->getAppication()['session']->setPreviousUrl($url);

        return $this;
    }
}
