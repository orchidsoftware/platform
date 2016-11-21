<?php

namespace Orchid\Foundation\Http\Controllers;

use Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard::index');
    }
}
