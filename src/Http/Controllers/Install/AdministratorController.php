<?php

namespace Orchid\Http\Controllers\Install;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Orchid\Http\Controllers\Controller;

class AdministratorController extends Controller
{
    /**
     * Administrator view.
     */
    public function administrator()
    {
        return view('dashboard::container.install.administrator');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @internal param Redirector $redirect
     */
    public function create(Request $request)
    {
        $exitCode = Artisan::call('make:admin', [
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return redirect()->route('install::final')
            ->with(['message' => $exitCode]);
    }
}
