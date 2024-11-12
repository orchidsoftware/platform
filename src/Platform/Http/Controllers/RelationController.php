<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\Crypt;
use Orchid\Platform\Http\Requests\RelationRequest;

class RelationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function view(RelationRequest $request)
    {
        [
            'model'         => $model,
            'name'          => $name,
            'key'           => $key,
            'scope'         => $scope,
            'append'        => $append,
            'searchColumns' => $searchColumns,
        ] = collect($request->all())
            ->except(['search', 'chunk'])
            ->map(static function ($item, $key) {
                if ($item === null) {
                    return null;
                }

                if ($key === 'scope' || $key === 'searchColumns') {
                    return Crypt::decrypt($item);
                }

                return Crypt::decryptString($item);
            });

        /** @var Model $model */
        /** @psalm-suppress UndefinedClass */
        $model = new $model;
        $search = $request->get('search', '');

        $items = $this->buildersItems($model, $name, $key, $search, $scope, $append, $searchColumns, (int) $request->get('chunk', 10));

        return response()->json($items);
    }

    /**
     * @return mixed
     */
    private function buildersItems(
        Model $model,
        string $name,
        string $key,
        ?string $search = null,
        ?array $scope = [],
        ?string $append = null,
        ?array $searchColumns = null,
        ?int $chunk = 10
    ) {
        if ($scope !== null) {
            /** @var Collection|array $model */
            $model = $model->{$scope['name']}(...$scope['parameters']);
        }

        if (is_array($model)) {
            $model = collect($model);
        }

        if (is_a($model, BaseCollection::class)) {
            return $model->take($chunk)->map(function ($item) use ($append, $key, $name) {
                return [
                    'value' => $item->$key,
                    'label' => $item->$append ?? $item->$name,
                ];
            });
        }

        $model = $model->where(function ($query) use ($name, $search, $searchColumns) {
            $query->where($name, 'like', '%'.$search.'%');

            if (is_array($searchColumns)) {
                $this->applySearchColumns($query, $searchColumns, $search);
            }
        });

        return $model
            ->limit($chunk)
            ->get()
            ->map(function ($item) use ($append, $key, $name) {
                $resultKey = $item->$key;

                $resultLabel = $item->$append ?? $item->$name;

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
            });
    }

    /**
     * @param          $query
     * @param string[] $searchColumns
     * @param null|string   $search
     *
     * @return void
     */
    private function applySearchColumns($query, array $searchColumns, ?string $search){
        foreach ($searchColumns as $column) {
            $lastDotPosition = strrpos($column, '.');
            if ($lastDotPosition !== false) {
                $query->whereHas(substr($column, 0, $lastDotPosition), function ($columnQuery) use ($search, $lastDotPosition, $column) {
                    $columnQuery->where(substr($column, $lastDotPosition), 'LIKE', '%'.$search.'%');
                });
            } else {
                $query->orWhere($column, 'like', '%'.$search.'%');
            }
        }
    }
}
