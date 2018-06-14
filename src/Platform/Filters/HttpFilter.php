<?php

declare(strict_types=1);

namespace Orchid\Platform\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HttpFilter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var
     */
    protected $filters;

    /**
     * @var
     */
    protected $sorts;

    /**
     * Model options and allowed params.
     *
     * @var
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
     * @param $query
     *
     * @return array
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
    protected function addSortsToQuery(Builder $builder)
    {
        $this->sorts
            ->each(function (string $sort) use ($builder) {
                $descending = $sort[0] === '-';
                $key = ltrim($sort, '-');
                $key = str_replace('.', '->', $key);
                $builder->orderBy($key, $descending ? 'desc' : 'asc');
            });
    }

    /**
     * @param Builder $builder
     */
    protected function addFiltersToQuery(Builder $builder)
    {
        $allowedFilters = $this->options->get('allowedFilters')->toArray();

        $this->filters->each(function ($value, $property) use ($builder, $allowedFilters) {
            $allowProperty = $property;
            if (false !== stristr($property, '.')) {
                $allowProperty = stristr($property, '.', true);
            }

            if (in_array($allowProperty, $allowedFilters)) {
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
        if (is_array($value)) {
            return $query->whereIn($property, $value);
        }

        return $query->where($property, $value);
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
     * @return bool|string
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
