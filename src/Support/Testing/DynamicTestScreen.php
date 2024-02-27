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
     * @var MakesHttpRequestsWrapper Wrapper for HTTP requests
     */
    protected $http;

    /**
     * Name of the route
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
     * Session data
     *
     * @var array
     */
    protected $session = [];

    /**
     * Indicates whether redirects should be followed.
     *
     * @var bool
     */
    protected bool $followRedirects = true;

    /**
     * Create a new DynamicTestScreen instance.
     *
     * @param string|null $name Route name
     */
    public function __construct(?string $name = null)
    {
        $this->http = app(MakesHttpRequestsWrapper::class);
        $this->name = $name ?? Str::uuid()->toString();
    }

    /**
     * Register a dynamic screen
     *
     * @param string       $screen     Screen name
     * @param string|null  $route      Route name
     * @param array|string $middleware Middleware to be used
     */
    public function register(string $screen, ?string $route = null, $middleware = 'web'): DynamicTestScreen
    {
        Route::screen('/_test/'.($route ?? $this->name), $screen)
            ->middleware($middleware)
            ->name($this->name);

        Route::getRoutes()->refreshNameLookups();
        Route::getRoutes()->refreshActionLookups();

        return $this;
    }

    /**
     * Set route parameters
     *
     * @param array $parameters Route parameters
     *
     * @return $this
     */
    public function parameters(array $parameters = []): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set session data
     *
     * @param array $data Session data
     *
     * @return $this
     */
    public function session(array $data): DynamicTestScreen
    {
        $this->session = $data;

        return $this;
    }

    /**
     * Get the test response for the screen.
     *
     * @param array $headers Headers to be used
     *
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     *
     * @return \Illuminate\Testing\TestResponse|mixed
     */
    public function display(array $headers = [])
    {
        return $this->http->get($this->route(), $headers);
    }

    /**
     * Call the specified screen method
     *
     * @param string $method     Method to call
     * @param array  $parameters Parameters to be used
     * @param array  $headers    Headers to be used
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function method(string $method, array $parameters = [], array $headers = []): TestResponse
    {
        $route = $this->route(array_merge(
            $this->parameters,
            ['method' => $method]
        ));

        $this->from($route);

        $http = $this->http->withSession($this->session);

        if ($this->followRedirects) {
            $http->followingRedirects();
        }

        return $http->post($route, $parameters, $headers);
    }

    /**
     * Call the specified screen method using alias
     */
    public function call(string $method, array $parameters = [], array $headers = []): TestResponse
    {
        return $this->method($method, $parameters, $headers);
    }

    /**
     * Get the route URL
     */
    protected function route(?array $parameters = null): string
    {
        return route($this->name, $parameters ?? $this->parameters);
    }

    /**
     * Set the currently logged-in user for the application.
     *
     * @param UserContract $user  User to act as
     * @param string|null  $guard Guard name
     */
    public function actingAs(UserContract $user, $guard = null): self
    {
        $this->be($user, $guard);

        return $this;
    }

    /**
     * Set the currently logged-in user for the application.
     *
     * @param UserContract $user  User to act as
     * @param string|null  $guard Guard name
     */
    public function be(UserContract $user, $guard = null): self
    {
        $this->http->be($user, $guard);

        return $this;
    }

    /**
     * Dynamically pass all other methods to Http calls
     *
     * @param string $name      Name of the method to call
     * @param mixed  $arguments Arguments to be passed
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
     * @param string $url URL of the previous request
     */
    public function from(string $url): self
    {
        $this->http->getApplication()['session']->setPreviousUrl($url);

        return $this;
    }

    /**
     * Automatically follow any redirects returned from the response.
     *
     * @return $this
     */
    public function followingRedirects(): self
    {
        $this->followRedirects = true;

        return $this;
    }

    /**
     * Disable automatic following of redirects returned from the response.
     *
     * @return $this
     */
    public function withoutFollowingRedirects(): self
    {
        $this->followRedirects = false;

        return $this;
    }
}
