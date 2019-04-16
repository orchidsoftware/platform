<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class HttpFilter
{
    /**
     * Column names are alphanumeric strings that can contain
     * underscores (`_`) but can't start with a number.
     */
    private const VALID_COLUMN_NAME_REGEX = '/^(?![0-9])[A-Za-z0-9_>-]*$/';

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
     *
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request ?? request();

        $this->filters = collect($this->request->get('filter', []))->map(function ($item) {
            return $this->parseHttpValue($item);
        });
        $this->sorts = collect($this->request->get('sort', []));
    }

    /**
     * @param string $query
     *
     * @return string|array
     */
    protected function parseHttpValue($query)
    {
        $item = explode(',', $query);

        if (count($item) > 1) {
            return $item;
        }

        return $query;
    }

    /**
     * @param string $column
     *
     * @return string
     */
    public static function sanitize(string $column): string
    {
        if (! preg_match(self::VALID_COLUMN_NAME_REGEX, $column)) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        return $column;
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function build(Builder $builder): Builder
    {
        $this->options = $builder->getModel()->getOptionsFilter();
        $this->addFiltersToQuery($builder);
        $this->addSortsToQuery($builder);

        return $builder;
    }

    /**
     * @param Builder $builder
     */
    protected function addFiltersToQuery(Builder $builder)
    {
        $allowedFilters = $this->options->get('allowedFilters')->toArray();

        $this->filters->each(function ($value, $property) use ($builder, $allowedFilters) {
            $allowProperty = $property;
            if (strpos($property, '.') !== false) {
                $allowProperty = strstr($property, '.', true);
            }

            if (in_array($allowProperty, $allowedFilters, true)) {
                $property = str_replace('.', '->', $property);
                $this->filtersExact($builder, $value, $property);
            }
        });
    }

    /**
     * @param Builder $query
     * @param         $value
     * @param string  $property
     *
     * @return Builder
     */
    protected function filtersExact(Builder $query, $value, string $property)
    {
        $property = $this->sanitize($property);

        if (is_array($value)) {
            return $query->whereIn($property, $value);
        }

        if (is_int($value)) {
            return $query->where($property, $value);
        }

        return $query->where($property, 'like', "%$value%");
    }

    /**
     * @param Builder $builder
     */
    protected function addSortsToQuery(Builder $builder)
    {
        $allowedSorts = $this->options->get('allowedSorts')->toArray();

        $this->sorts
            ->each(function (string $sort) use ($builder, $allowedSorts) {
                $descending = strpos($sort, '-') === 0;
                $key = ltrim($sort, '-');
                $key = str_replace('.', '->', $key);

                if (in_array($key, $allowedSorts, true)) {
                    $key = $this->sanitize($key);
                    $builder->orderBy($key, $descending ? 'desc' : 'asc');
                }
            });
    }

    /**
     * @param null $property
     *
     * @return bool
     */
    public function isSort($property = null)
    {
        if (is_null($property)) {
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

    /**
     * @param $property
     *
     * @return mixed
     */
    public function revertSort($property)
    {
        if ($this->getSort($property) === 'asc') {
            return '-'.$property;
        }

        return $property;
    }

    /**
     * @param $property
     *
     * @return string
     */
    public function getSort($property)
    {
        if ($this->sorts->search($property, true) !== false) {
            return 'asc';
        }

        return 'desc';
    }

    /**
     * @param $property
     *
     * @return mixed
     */
    public function getFilter($property)
    {
        return array_get($this->filters, $property);
    }
}
