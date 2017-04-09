<?php

namespace Orchid\Http\Controllers\Marketing;

use Orchid\Http\Controllers\Controller;

class UTMController extends Controller
{
    /**
     * UTMController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.marketing.utm');
    }

    /**
     * @return string
     */
    public function index()
    {
        return view('dashboard::container.marketing.utm.generate');
    }
}
