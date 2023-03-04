<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class IndexController.
 */
class IndexController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route(config('platform.index'));
    }

    /**
     * @return Factory|View
     */
    public function fallback()
    {
        return view('platform::errors.404');
    }
}
