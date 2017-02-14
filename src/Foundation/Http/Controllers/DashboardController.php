<?php

namespace Orchid\Foundation\Http\Controllers;

use Dashboard;

class DashboardController extends Controller
{
    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {
        return view('dashboard::index');
    }
}
