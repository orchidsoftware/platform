<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\Crypt;
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
        [
            'model'  => $model,
            'name'   => $name,
            'key'    => $key,
            'scope'  => $scope,
            'append' => $append,
        ] = collect($request->except(['search']))->map(static function ($item, $key) {

            if ($item === null) {
                return null;
            }

            if($key === 'scope'){
                return  Crypt::decrypt($item);
            }

            return Crypt::decryptString($item);
        });

        /** @var Model $model */
        $model = new $model;
        $search = $request->get('search', '');

        $items = $this->buildersItems($model, $name, $key, $search, $scope, $append);

        return response()->json($items);
    }

    /**
     * @param Model       $model
     * @param string      $name
     * @param string      $key
     * @param string|null $search
     * @param array|null  $scope
     * @param string|null $append
     *
     * @return mixed
     */
    private function buildersItems(
        Model $model,
        string $name,
        string $key,
        string $search = null,
        ?array $scope = [],
        ?string $append = null)
    {
        if ($scope !== null) {
            /** @var Collection|array $model */
            $model = $model->{$scope['name']}(...$scope['parameters']);
        }

        if (is_array($model)) {
            $model = collect($model);
        }

        if (is_a($model, BaseCollection::class)) {
            return $model->take(10)->pluck($append ?? $name, $key);
        }

        return $model
            ->where($name, 'like', '%'.$search.'%')
            ->limit(10)
            ->get()
            ->pluck($append ?? $name, $key);
    }
}
