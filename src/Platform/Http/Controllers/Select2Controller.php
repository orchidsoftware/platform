<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Orchid\Platform\Http\Requests\Select2Request;
use Orchid\Support\Select2LazyQuery;

class Select2Controller extends Controller
{

    public function view(Select2Request $request)
    {
        $display = $request->get('display');
        $search = $request->get('search');
        $key = $request->get('key');

        $query = Select2LazyQuery::execute($request->get('query'), $search);

        return response()->json($query->get()->map(function ($item) use ($display, $key) {
            $resultKey = $item->$key;

            $resultLabel = $item->$display;

            if ($resultKey instanceof \UnitEnum) {
                $resultKey = $resultKey->value;
            }
            if ($resultLabel instanceof \UnitEnum) {
                $resultLabel = $resultLabel->value;
            }

            return [
                'value' => $resultKey,
                'label' => $resultLabel,
            ];
        }));
    }
}
