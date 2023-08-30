<?php

declare(strict_types=1);

namespace Orchid\Support\Testing;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

/**
 * Trait MakesHttpRequestsWrapper
 *
 * This trait contains some helper methods to provide additional functionality
 * to the middleware. Specifically, it provides various HTTP helper methods to
 * simulate basic HTTP requests to endpoints.
 */
class MakesHttpRequestsWrapper
{
    use InteractsWithAuthentication, InteractsWithExceptionHandling, InteractsWithSession, MakesHttpRequests;

    /**
     * The application instance
     *
     * @var Application
     */
    protected $app;

    /**
     * Creates a new wrapper instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get the instance of the application
     *
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->app;
    }
}
