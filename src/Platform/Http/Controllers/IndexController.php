<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class IndexController.
 */
class IndexController extends Controller
{
    /**
     * Redirect to the configured index route.
     */
    public function index(): RedirectResponse
    {
        return redirect()->route(config('platform.index'));
    }

    /**
     * Show the fallback view for undefined routes.
     */
    public function fallback(): View
    {
        return view('platform::errors.404');
    }
}
