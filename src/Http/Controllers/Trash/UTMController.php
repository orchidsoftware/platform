<?php

namespace Orchid\Platform\Http\Controllers\Trash;

use Orchid\Platform\Http\Controllers\Controller;

class UTMController extends Controller
{
    /**
     * UTM Controller constructor.
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
