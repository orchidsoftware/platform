<?php

namespace Orchid\Platform\Http\Controllers\Install;

use Illuminate\Support\Facades\Artisan;
use Orchid\Platform\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        try {
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('vendor:publish', [
                '--all'   => true,
                '--force' => true,
            ]);
            Artisan::call('event:generate');
            Artisan::call('storage:link');
            Artisan::call('make:auth', [
                '--force' => true,
            ]);
        } catch (\Exception $exception) {
            $exception = $exception->getMessage();
        }

        return view('dashboard::container.install.welcome', [
            'exception' => isset($exception) ? $exception : null,
        ]);
    }
}
