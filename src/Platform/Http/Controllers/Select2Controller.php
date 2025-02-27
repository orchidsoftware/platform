<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Orchid\Platform\Http\Requests\RelationRequest;

class Select2Controller extends Controller
{

    public function view(Request $request)
    {
        Log::info($request->input('query'));
        $result = DB::select($request->input('query'));

        Log::info(json_encode($result));

        return response()->json($model->limit($chunk)->get()->map(function ($item) {
            return [
                'label' => $item->name,
                'value' => $item->email,
            ];
        }));
    }

    /**
     * @return JsonResponse
     */
    public function view1(Request $request)
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

        Log::info('model', [$model]);

        if ($scope !== null) {
            /** @var Collection|array $model */
            $model = $model->{$scope['name']}(...$scope['parameters']);
        }

        if (is_array($model)) {
            $model = collect($model);
        }

        if (is_a($model, BaseCollection::class)) {
            return $model->take($chunk)->map(function ($item) use ($append, $key, $name) {
                Log::info('321');
                return [
                    'value' => $item->$key,
                    'label' => $item->$append ?? $item->$name,
                ];
            });
        }

        if (InstalledVersions::satisfies(new VersionParser, 'laravel/framework', '>11.17.0')) {
            $model = $model->where(function ($query) use ($name, $search, $searchColumns) {
                $value = '%'.$search.'%';

                $query->whereLike($name, $value);

                $query->when($searchColumns !== null, function ($query) use ($searchColumns, $value) {
                    foreach ($searchColumns as $column) {
                        $query->orWhereLike($column, $value);
                    }
                });
            });
        } else {
            /**
             * @deprecated logic for older Laravel versions
             */
            $model = $model->where(function ($query) use ($name, $search, $searchColumns) {
                $value = '%'.$search.'%';

                $query->where($name, 'like', $value);

                $query->when($searchColumns !== null, function ($query) use ($searchColumns, $value) {
                    foreach ($searchColumns as $column) {
                        $query->orWhere($column, 'like', $value);
                    }
                });
            });
        }

        Log::info('123', [
            $chunk, $model, $key, $name,
        ]);

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
}
