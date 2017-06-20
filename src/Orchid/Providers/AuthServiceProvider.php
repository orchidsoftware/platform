<?php

namespace Orchid\Providers;

use Illuminate\Auth\AuthServiceProvider as AuthProvider;

class AuthServiceProvider extends AuthProvider
{

    /**
     * Register any gate for application.
     */
    public function boot()
    {
        $this->registerAccessGate();
    }

    /**
     * Register the access gate service resolving the user.
     *
     * @return void
     */
    protected function registerAccessGate()
    {
        /*
        Gate::define('dashboard.posts.type.create', function ($user) {

        });
        */
    }
}
