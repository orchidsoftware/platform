<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Orchid\Platform\Http\Controllers\Controller;

class SystemController extends Controller
{
    /**
     * SystemController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('platform.systems.index');
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('platform::systems');
    }
}
