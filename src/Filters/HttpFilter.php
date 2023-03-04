<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class HttpFilter
{
    /**
     * Column names are alphanumeric strings that can contain
     * underscores (`_`) but can't start with a number.
     */
    private const VALID_COLUMN_NAME_REGEX = '/^(?![\d])[A-Za-z0-9_>-]*$/';
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Collection
     */
    protected $filters;

    /**
     * @var Collection
     */
    protected $sorts;

    /**
     * Model options and allowed params.
     *
     * @var Collection
     */
    protected $options;

    /**
     * Filter constructor.
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request ?? request();

        $this->filters = $this->request->collect('filter')->filter(fn ($item) => $item !== null);
        $this->sorts = collect($this->request->collect('sort'));
    }

    public function build(Builder $builder): Builder
    {
        $this->options = $builder->getModel()->getOptionsFilter();

        $this
            ->addFiltersToQuery($builder)
            ->addSortsToQuery($builder);

        return $builder;
    }

    public static function sanitize(string $column): string
    {
        abort_unless(preg_match(self::VALID_COLUMN_NAME_REGEX, $column), Response::HTTP_BAD_REQUEST);

        return $column;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    protected function addFiltersToQuery(Builder $builder)
    {
        $filters = $this->options->get('allowedFilters')
            ->map(fn ($filter, string $column) => app()->make($filter, ['column' => $column]));

        $builder->filtersApply($filters);

        return $this;
    }

    protected function addSortsToQuery(Builder $builder)
    {
        /** @var Collection $allowedSorts */
        $allowedSorts = $this->options->get('allowedSorts');

        $this->sorts
            ->map(fn (string $sort) => Str::of($sort))
            ->each(function (Stringable $sort) use ($builder, $allowedSorts) {
                $descending = $sort->startsWith('-') ? 'desc' : 'asc';

                $column = Str::of($sort)->ltrim('-')->replace('.', '->');
                $key = $column->before('->');

                if ($allowedSorts->containsStrict($key->toString())) {
                    $safe = $this->sanitize($column->toString());

                    $builder->orderBy($safe, $descending);
                }
            });

        return $this;
    }

    public function isSort(string $property = null): bool
    {
        if ($property === null) {
            return $this->sorts->isEmpty();
        }

        if ($this->sorts->search($property, true) !== false) {
            return true;
        }

        if ($this->sorts->search('-'.$property, true) !== false) {
            return true;
        }

        return false;
    }

    public function revertSort(string $property): string
    {
        return $this->getSort($property) === 'asc'
            ? '-'.$property
            : $property;
    }

    public function getSort(string $property): string
    {
        return $this->sorts->search($property, true) !== false
            ? 'asc'
            : 'desc';
    }

    /**
     * @return mixed
     */
    public function getFilter(string $property)
    {
        return Arr::get($this->filters, $property);
    }
}
