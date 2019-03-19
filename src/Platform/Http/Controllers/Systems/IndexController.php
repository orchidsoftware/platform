<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

/**
 * Class IndexController.
 */
class IndexController
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route(config('platform.index'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fallback()
    {
        return view('platform::errors.404');
    }
}
