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
        ] = collect($request->except(['search']))->map(static function ($item) {
            return is_null($item) ? null : Crypt::decryptString($item);
        });

        /** @var Model $model */
        $model = new $model;
        $search = $request->get('search', '');

        $method = is_a($model, Model::class) ? 'buildersItems' : 'getItems';

        $items = $this->{$method}($model, $name, $key, $search, $scope, $append);

        return response()->json($items);
    }

    /**
     * @param Model       $model
     * @param string      $name
     * @param string      $key
     * @param string|null $search
     * @param string|null $scope
     * @param string|null $append
     *
     * @return mixed
     */
    private function buildersItems(Model $model, string $name, string $key, string $search = null, string $scope = null, string $append = null)
    {
        if ($scope !== null) {
            $model = $model->{$scope}();
        }

        if (is_array($model)) {
            $model = collect($model);
        }

        if (is_a($model, BaseCollection::class)) {
            return $model->take(10)->pluck($append ?? $name, $key);
        }

        return $model
            ->where($name, 'like', '%' . $search . '%')
            ->limit(10)
            ->get()
            ->pluck($append ?? $name, $key);
    }

    /**
     * @param array|object|Model $model
     * @param string             $name
     * @param string             $key
     * @param string             $search
     * @param string|null        $scope
     *
     * @param string|null        $append
     *
     * @return Collection|array
     */
    private function getItems($model, string $name, string $key, string $search = null, string $scope = null, string $append = null): iterable
    {
        if (! is_array($model) && property_exists($model, 'search')) {
            $model->search = $search;
        }

        /* Execution branch for source class */
        if (is_null($scope)) {
            $model = $model->handler();
        }

        $items = collect($model);

        if (! is_iterable($model)) {
            $items = collect($model->get());
        }

        if (! empty($search)) {
            $items = $items->filter(static function ($item) use ($name, $search) {
                return stripos($item[$name], $search) !== false;
            });
        }

        return $items->take(10)->pluck($name, $key);
    }
}
