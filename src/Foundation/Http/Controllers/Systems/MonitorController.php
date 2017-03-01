<?php

namespace Orchid\Foundation\Http\Controllers\Systems;


use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Monitor\Monitor;

class MonitorController extends Controller
{

    /**
     * MonitorController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.systems.monitor');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $monitor = new Monitor();
        return view('dashboard::container.systems.monitor.index',[
            'info' => $monitor->info(),
            'hardware' => $monitor->hardware(),
            'loadAverage' => $monitor->loadAverage(),
            'memory' => $monitor->memory(),
            'network' => $monitor->network(),
            'storage' => $monitor->storage(),
        ]);
    }
}