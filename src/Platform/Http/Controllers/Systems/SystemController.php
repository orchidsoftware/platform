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
        $this->checkPermission('platform.systems.index');
    }

    /**
     * @return string
     */
    public function index()
    {
        $settings = collect(config('app'))->only([
            'name',
            'env',
            'debug',
            'url',
            'timezone',
            'locale',
            'fallback_locale',
            'log',
            'log_level',
        ])->map(function ($item){
            if(is_bool($item)){
                $item = $item ? 'Enabled': 'Disabled';
            }
            return $item;
        });

        return view('platform::container.systems.index', [
            'settings' => $settings,
        ]);
    }
}
