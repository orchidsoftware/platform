<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
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
        $query = $payload->query();

        if (! $query instanceof Builder) {
            return collect($query)
                ->take($payload->chunk)
                ->map(fn ($item) => $payload->optionFrom($item))
                ->values()
                ->all();
        }

        $this->applySearch($query, $payload);

        return $query
            ->limit($payload->chunk)
            ->get()
            ->map(fn ($item) => $payload->optionFrom($item))
            ->values()
            ->all();
    }

    /**
     * Apply search filter to the query.
     *
     * @param Builder<covariant \Illuminate\Database\Eloquent\Model> $query
     */
    private function applySearch(Builder $query, ChoicePayload $payload): void
    {
        if ($payload->search === '') {
            return;
        }

        $value = '%'.$payload->search.'%';
        $query->where(function (Builder $q) use ($payload, $value): void {
            $columns = $payload->searchableColumns();
            $name = array_shift($columns);

            $q->whereLike($name, $value);
            foreach ($columns as $column) {
                $q->orWhereLike($column, $value);
            }
        });
    }
}
