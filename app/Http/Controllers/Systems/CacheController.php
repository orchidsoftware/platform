<?php

namespace Orchid\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Orchid\Alert\Facades\Alert;

class CacheController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard::container.systems.cache.index');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $action = $request->get('action', 'index');
        $this->$action();
        Alert::success('success');

        return redirect()->back();
    }

    /**
     *  Flush the application cache.
     */
    protected function cache()
    {
        Artisan::call('cache:clear');
    }

    /**
     * Create a cache file for faster configuration loading.
     */
    protected function config()
    {
        Artisan::call('config:cache');
    }

    /**
     * Create a route cache file for faster route registration.
     */
    protected function route()
    {
        try {
            Artisan::call('route:cache');
        } catch (\Symfony\Component\Debug\Exception\FatalThrowableError $exception) {
            Alert::error('error');

            return redirect()->back();
        } catch (\LogicException $exception) {
            Alert::error('error');

            return redirect()->back();
        }
    }

    /**
     * Clear all compiled view files.
     */
    protected function view()
    {
        Artisan::call('view:clear');
    }
}
