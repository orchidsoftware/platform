<?php

declare(strict_types=1);

namespace Orchid\Support\Testing;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Support\Traits\Conditionable;

/**
 * Trait MakesHttpRequestsWrapper
 *
 * This trait contains some helper methods to provide additional functionality
 * to the middleware. Specifically, it provides various HTTP helper methods to
 * simulate basic HTTP requests to endpoints.
 */
class MakesHttpRequestsWrapper
{
    use Conditionable, InteractsWithAuthentication, InteractsWithExceptionHandling, InteractsWithSession, MakesHttpRequests;

    /**
     * Creates a new wrapper instance.
     *
     * @param Application $app The application instance
     */
    public function __construct(protected Application $app) {}

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
