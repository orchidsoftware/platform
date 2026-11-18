<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Orchid\Screen\Layouts\Selection;
use ReflectionClass;

trait Filterable
{
    /**
     * Apply the filter to the given query.
     *
     * @param Builder<static>                       $query
     * @param iterable<Filter|class-string<Filter>> $filters
     *
     * @return Builder<static>
     */
    #[Scope]
    protected function filtersApply(Builder $query, iterable $filters = []): Builder
    {
        return collect($filters)
            ->map(fn ($filter) => is_object($filter) ? $filter : resolve($filter))
            ->reduce(fn (Builder $query, Filter $filter) => $filter->filter($query), $query);
    }

    /**
     * Apply the filter to the given selection.
     *
     * @param Builder<static>  $query
     * @param string|Selection $class
     *
     * @return Builder<static>
     */
    #[Scope]
    protected function filtersApplySelection(Builder $query, $class): Builder
    {
        /** @var Selection $selection */
        $selection = is_object($class) ? $class : resolve($class);

        $filters = $selection->filters();

        return $this->filtersApply($query, $filters);
    }

    /**
     * @param Builder<static>                                             $builder
     * @param iterable<Filter|class-string<Filter>>|string|Selection|null $kit
     *
     * @return Builder<static>
     */
    #[Scope]
    protected function filters(Builder $builder, mixed $kit = null, ?HttpFilter $httpFilter = null): Builder
    {
        $filter = $httpFilter ?? new HttpFilter;
        $filter->build($builder);

        if ($kit === null) {
            return $builder;
        }

        return is_iterable($kit)
            ? $this->filtersApply($builder, $kit)
            : $this->filtersApplySelection($builder, $kit);
    }

    /**
     * @param Builder<static> $builder
     *
     * @return Builder<static>
     */
    #[Scope]
    protected function defaultSort(Builder $builder, string $column, string $direction = 'asc')
    {
        if (empty($builder->getQuery()->orders)) {
            $builder->orderBy($column, $direction);
        }

        return $builder;
    }

    /**
     * Return the model's allowed filters and sort columns.
     *
     * @return Collection<string, Collection<array-key, string>>
     */
    public function getOptionsFilter(): Collection
    {
        return collect([
            'allowedFilters' => collect($this->allowedFilterColumns(AllowedFilters::class)),
            'allowedSorts'   => collect($this->allowedFilterColumns(AllowedSorts::class)),
        ]);
    }

    /**
     * Use the nearest declaration, including an explicitly empty list.
     *
     * @param class-string<AllowedFilters|AllowedSorts> $attribute
     *
     * @return array<array-key, string>
     */
    private function allowedFilterColumns(string $attribute): array
    {
        $class = new ReflectionClass($this);

        while ($class !== false) {
            $attributes = $class->getAttributes($attribute);

            if ($attributes !== []) {
                return $attributes[0]->newInstance()->columns;
            }

            $class = $class->getParentClass();
        }

        return [];
    }
}
