<?php namespace Orchid\Installer\Controllers;

use Illuminate\Routing\Redirector;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Artisan;

class AdministratorController extends Controller
{
    /**
     * Administrator view
     */
    public function administrator()
    {
        return view('install::administrator');
    }

    /**
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, Redirector $redirect)
    {
        $exitCode = Artisan::call('make:admin', [
            'name' =>  $request->input('name'),
            'email' =>  $request->input('email'),
            'password' =>  $request->input('password'),
        ]);

        return redirect()->route('install::final')
            ->with(['message' => $exitCode]);
    }
}
