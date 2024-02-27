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
     * Regular expression to validate column names. Column names can contain
     * alphanumeric characters and underscores (`_`), but can't start with a number.
     */
    private const VALID_COLUMN_NAME_REGEX = '/^(?![\d])[A-Za-z0-9_>-]*$/';
    /**
     * @var Request
     */
    protected $request;

    /**
     * Collection of filters extracted from the request.
     *
     * @var Collection
     */
    protected $filters;

    /**
     * Collection of sorts extracted from the request.
     *
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
     * HttpFilter constructor.
     *
     * @param Request|null $request The request object to use. If null, use the default request object.
     */
    public function __construct(?Request $request = null)
    {
        $this->request = $request ?? request();

        // Extract filters from the request
        $this->filters = $this->request->collect('filter')->filter(fn ($item) => $item !== null);

        // Extract sorts from the request
        $this->sorts = collect($this->request->collect('sort'));
    }

    /**
     * Builds the query based on the filters and sorts extracted from the request.
     *
     * @param Builder $builder The builder to add the filters and sorts to.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Builder The builder with the filters and sorts added.
     */
    public function build(Builder $builder): Builder
    {
        $this->options = $builder->getModel()->getOptionsFilter();

        $this
            ->addFiltersToQuery($builder)
            ->addSortsToQuery($builder);

        return $builder;
    }

    /**
     * Sanitizes a column name to ensure that it's valid.
     *
     * @param string $column The column name to sanitize.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return string The sanitized column name.
     */
    public static function sanitize(string $column): string
    {
        abort_unless(preg_match(self::VALID_COLUMN_NAME_REGEX, $column), Response::HTTP_BAD_REQUEST);

        return $column;
    }

    /**
     * Adds filters to the query.
     *
     * @param Builder $builder The builder to add the filters to.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return HttpFilter This HttpFilter instance.
     */
    protected function addFiltersToQuery(Builder $builder)
    {
        $filters = $this->options->get('allowedFilters')
            ->map(fn ($filter, string $column) => app()->make($filter, ['column' => $column]));

        $builder->filtersApply($filters);

        return $this;
    }

    /**
     * Applies the sorts to the Eloquent query builder.
     *
     * @param Builder $builder The Eloquent query builder to apply sorts to.
     *
     * @return HttpFilter This HttpFilter instance.
     */
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

    public function isSort(?string $property = null): bool
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
