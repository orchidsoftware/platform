<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

/**
 * Class IndexController.
 */
class IndexController
{
    /**
     * @return RedirectResponse
     */
    public function index()
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
