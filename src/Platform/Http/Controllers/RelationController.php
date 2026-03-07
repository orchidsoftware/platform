<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as BaseCollection;
use Orchid\Platform\Http\Requests\RelationRequest;

class RelationController extends Controller
{
    /**
     * Return options for the lazy select field (paginated search).
     */
    public function __invoke(RelationRequest $request): JsonResponse
    {
        $payload = $request->resolvedPayload();

        $items = $this->resolveOptions(
            $payload['model'],
            $payload['name'],
            $payload['key'],
            $payload['search'],
            $payload['chunk'],
            $payload['scope'],
            $payload['append'],
            $payload['searchColumns']
        );

        return response()->json($items);
    }

    /**
     * Resolve options for the given model and search term.
     *
     * @param  array{name: string, parameters: array}|null  $scope
     * @param  array<int, string>|null  $searchColumns
     * @return array<int, array{value: mixed, label: mixed}>
     */
    private function resolveOptions(
        string $modelClass,
        string $name,
        string $key,
        ?string $search,
        int $chunk,
        ?array $scope,
        ?string $append,
        ?array $searchColumns
    ): array {
        $search = $search ?? '';
        /** @var Model $model */
        $model = new $modelClass;

        $queryOrCollection = $this->applyScope($model, $scope);

        if ($queryOrCollection instanceof BaseCollection || is_array($queryOrCollection)) {
            $collection = collect($queryOrCollection);

            return $collection
                ->take($chunk)
                ->map(fn ($item) => $this->formatOption($item, $key, $name, $append))
                ->values()
                ->all();
        }

        $builder = $queryOrCollection instanceof Builder ? $queryOrCollection : $model->newQuery();
        $this->applySearch($builder, $name, $search, $searchColumns);

        return $builder
            ->limit($chunk)
            ->get()
            ->map(fn ($item) => $this->formatOption($item, $key, $name, $append))
            ->values()
            ->all();
    }

    /**
     * Apply scope to the model (e.g. for tenant or custom filtering).
     * Laravel scopes receive the query builder as first argument.
     *
     * @param  array{name: string, parameters: array}|null  $scope
     * @return Builder|Collection|array
     */
    private function applyScope(Model $model, ?array $scope): Builder|Collection|array
    {
        $query = $model->newQuery();

        if ($scope === null || $scope === []) {
            return $query;
        }

        return $query->{$scope['name']}(...($scope['parameters'] ?? []));
    }

    /**
     * Apply search filter to the query.
     *
     * @param  array<int, string>|null  $searchColumns
     */
    private function applySearch(Builder $query, string $name, string $search, ?array $searchColumns): void
    {
        if ($search === '') {
            return;
        }

        $value = '%' . $search . '%';
        $useWhereLike = InstalledVersions::satisfies(new VersionParser(), 'laravel/framework', '>11.17.0');

        $query->where(function (Builder $q) use ($name, $value, $searchColumns, $useWhereLike): void {
            if ($useWhereLike) {
                $q->whereLike($name, $value);
                if ($searchColumns !== null) {
                    foreach ($searchColumns as $column) {
                        $q->orWhereLike($column, $value);
                    }
                }
            } else {
                $q->where($name, 'like', $value);
                if ($searchColumns !== null) {
                    foreach ($searchColumns as $column) {
                        $q->orWhere($column, 'like', $value);
                    }
                }
            }
        });
    }

    /**
     * Format a single item for TomSelect (value/label).
     *
     * @param  object|array  $item
     * @return array{value: mixed, label: mixed}
     */
    private function formatOption(object|array $item, string $key, string $name, ?string $append): array
    {
        $arr = is_array($item) ? $item : (array) $item;
        $obj = is_object($item) ? $item : (object) $item;

        $value = is_array($item)
            ? ($arr[$key] ?? null)
            : $obj->$key;
        $label = $append !== null && $append !== ''
            ? (is_array($item) ? ($arr[$append] ?? $arr[$name] ?? $value) : ($obj->$append ?? $obj->$name ?? $value))
            : (is_array($item) ? ($arr[$name] ?? $value) : ($obj->$name ?? $value));

        return [
            'value' => $value instanceof \UnitEnum ? $value->value : $value,
            'label' => $label instanceof \UnitEnum ? $label->value : $label,
        ];
    }
}
