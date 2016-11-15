<?php namespace Orchid\Installer\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

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
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return view('install::welcome');
    }
}
