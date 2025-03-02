<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Orchid\Platform\Http\Requests\Select2Request;
use Orchid\Support\Select2QLazyQuery;

class Select2Controller extends Controller
{

    public function view(Select2Request $request)
    {
        $display = $request->get('display');
        $search = $request->get('search');
        $key = $request->get('key');

        $query = Select2QLazyQuery::execute($request->get('query'), $search);

        return response()->json($query->get()->map(function ($item) use ($display, $key) {
            return [
                'label' => $item->$display,
                'value' => $item->$key,
            ];
        }));
    }
}
