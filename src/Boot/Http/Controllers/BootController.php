<?php

namespace Orchid\Boot\Http\Controllers;

use Orchid\Platform\Http\Controllers\Controller;

class BootController extends Controller
{
    /**
     * BootController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('platform.systems.attachment');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('platform::container.boot.index');
    }
}