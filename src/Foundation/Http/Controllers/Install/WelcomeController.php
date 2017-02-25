<?php

namespace Orchid\Foundation\Http\Controllers\Install;

use Illuminate\Support\Facades\Artisan;
use Orchid\Foundation\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        Artisan::call('vendor:publish');
        Artisan::call('event:generate');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('storage:link');

        return view('dashboard::container.install.welcome');
    }
}
