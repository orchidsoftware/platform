<?php

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Contracts\View\View;
use Orchid\Support\Facades\Orchid;

class SearchController
{
    /**
     * Display a search result view.
     */
    public function search(?string $query = null): View
    {
        return view('orchid::partials.search.results', [
            'results' => Orchid::search($query),
            'query'   => $query,
        ]);
    }
}
