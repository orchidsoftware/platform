<?php

namespace Orchid\Installer\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;

class AdministratorController extends Controller
{
    /**
     * Administrator view.
     */
    public function administrator()
    {
        return view('install::administrator');
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
