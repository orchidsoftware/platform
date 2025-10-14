<?php

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Contracts\View\View;
use Orchid\Support\Facades\Dashboard;

class SearchController
{
    /**
     * Display a search result view.
     */
    public function search(?string $query = null): View
    {
        return view('platform::partials.search-result', [
            'results' => Dashboard::search($query),
            'query'   => $query,
        ]);
    }
}
