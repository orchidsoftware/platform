<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('dashboard::container.tools.menu.listing', [
            'menu'    => collect(config('content.menu')),
            'locales' => collect(config('content.locales')),
        ]);
    }

    /**
     * @param $menu
     *
     * @return View
     */
    public function show($menu)
    {
        return view('dashboard::container.tools.menu.menu', [

        ]);
    }

    /**
     * @param Request $request
     * @param $menu
     */
    public function update(Request $request, $menu)
    {
    }
}
