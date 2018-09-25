<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Orchid\Platform\Dashboard;

class GlobalSearchController
{
    /**
     * @param \Orchid\Platform\Dashboard $dashboard
     * @param \Illuminate\Http\Request   $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Dashboard $dashboard, Request $request)
    {
        $result = $dashboard->getGlobalSearch()->map(function ($model) use ($request) {
            return [
                'label'  => $model->searchLabel(),
                'result' => $model->search($request->get('search'))->limit(5),
            ];
        });

        return view('platform::partials.result',[
            'result' => $result
        ]);
    }
}