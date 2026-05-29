<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as BaseCollection;
use Orchid\Platform\Http\Requests\ChoicesRequest;
use Orchid\Screen\Fields\Support\ChoicePayload;

class ChoicesController extends Controller
{
    /**
     * Return choices for fields that load selectable values over HTTP.
     */
    public function __invoke(ChoicesRequest $request): JsonResponse
    {
        $items = $this->resolveChoices($request->payload());

        return response()->json($items);
    }

    /**
     * Resolve choices for the given model and search term.
     *
     * @return array<int, array{value: mixed, label: mixed}>
     */
    private function resolveChoices(ChoicePayload $payload): array
    {
        $queryOrCollection = $payload->query();

        if ($queryOrCollection instanceof BaseCollection || is_array($queryOrCollection)) {
            $collection = collect($queryOrCollection);

            return $collection
                ->take($payload->chunk)
                ->map(fn ($item) => $payload->optionFrom($item))
                ->values()
                ->all();
        }

        $builder = $queryOrCollection instanceof Builder
            ? $queryOrCollection
            : $payload->modelInstance()->newQuery();

        $this->applySearch($builder, $payload);

        return $builder
            ->limit($payload->chunk)
            ->get()
            ->map(fn ($item) => $payload->optionFrom($item))
            ->values()
            ->all();
    }

    /**
     * Apply search filter to the query.
     */
    private function applySearch(Builder $query, ChoicePayload $payload): void
    {
        if ($payload->search === '') {
            return;
        }

        $value = '%'.$payload->search.'%';
        $useWhereLike = InstalledVersions::satisfies(
            new VersionParser(),
            'laravel/framework',
            '>11.17.0'
        );

        $query->where(function (Builder $q) use ($payload, $value, $useWhereLike): void {
            $columns = $payload->searchableColumns();
            $name = array_shift($columns);

            if ($useWhereLike) {
                $q->whereLike($name, $value);
                foreach ($columns as $column) {
                    $q->orWhereLike($column, $value);
                }

                return;
            }

            $q->where($name, 'like', $value);
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', $value);
            }
        });
    }
}
