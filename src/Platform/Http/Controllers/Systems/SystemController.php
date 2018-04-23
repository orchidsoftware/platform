<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Orchid\Platform\Http\Controllers\Controller;

class SystemController extends Controller
{
    /**
     * SystemController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.systems.index');
    }

    /**
     * @return string
     */
    public function index()
    {
        return view('dashboard::container.systems.index');
    }
}
