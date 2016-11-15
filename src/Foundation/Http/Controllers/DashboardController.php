<?php

namespace Orchid\Foundation\Http\Controllers;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard::index');
    }
}
