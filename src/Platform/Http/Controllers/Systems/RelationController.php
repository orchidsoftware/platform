<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Platform\Http\Requests\RelationRequest;

class RelationController extends Controller
{
    /**
     * @param RelationRequest $request
     *
     * @return JsonResponse
     */
    public function view(RelationRequest $request)
    {
        ['model' => $model, 'name' => $name, 'key' => $key, 'scope' => $scope] = collect($request->except(['search']))->map(function ($item) {
            return is_null($item) ? null : Crypt::decryptString($item);
        });

        /** @var Model $builder */
        $model = new $model;
        $search = $request->get('search', '');

        if (! is_null($scope)) {
            $model = $model->{$scope}();
        }

        $items = $model
            ->where($name, 'like', '%'.$search.'%')
            ->limit(10)
            ->pluck($name, $key);

        return response()->json($items);
    }
}
