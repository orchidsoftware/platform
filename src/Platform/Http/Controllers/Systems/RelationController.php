<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Platform\Http\Requests\RelationRequest;

class RelationController extends Controller
{
    /**
     * @param RelationRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(RelationRequest $request)
    {
        $params = collect($request->except(['search']))->map(function ($item) {
            return Crypt::decryptString($item);
        });

        /** @var Model $builder */
        $model = new $params['model'];
        $name = $params['name'];
        $key = $params['key'];
        $search = $request->get('search', '');

        $items = $model
            ->where($name, 'like', '%'.$search.'%')
            ->limit(10)
            ->pluck($name, $key);

        return response()->json($items);
    }
}
