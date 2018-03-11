<?php

declare(strict_types=1);

namespace Orchid\Platform\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Filter
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
     * @var
     */
    protected $includes;

    /**
     * Model options and allowed params
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
        $this->options = collect([
            'allowedFilters'  => collect($this->request->get('filter', []))->keys()->flatten(),
            'allowedSorts'    => collect($this->request->get('sort', [])),
            'allowedIncludes' => collect([]),
        ]);
        $this->parseHttpQuery();
    }

    /**
     *
     */
    protected function parseHttpQuery()
    {
        $this->filters = $this->allowedHttpQueryArray('filter', 'allowedFilters');
        $this->sorts = $this->allowedHttpQuery('sort', 'allowedSorts');
        $this->includes = $this->allowedHttpQuery('include', 'allowedIncludes');
    }

    /**
     * @param string $query
     * @param string $allowed
     * @return array
     */
    protected function allowedHttpQueryArray(string $query, string $allowed)
    {

        $allowedHttpQuery = $this->options->get($allowed)->map(function ($value) use ($query) {
            return "{$query}.{$value}";
        })->toArray();

        return collect($this->parseHttpValue($this->request->only($allowedHttpQuery))->get($query));
    }

    /**
     * @param array $query
     * @return array
     */
    protected function parseHttpValue($query)
    {
        $query = collect($query);

        array_walk_recursive($query, function (&$item) {
            if (!is_array($item) && count(explode(',', $item)) > 1) {
                $item = explode(',', $item);
            }
        });

        return $query;
    }

    /**
     * @param string $query
     * @param string $allowed
     * @return array
     */
    protected function allowedHttpQuery(string $query, string $allowed)
    {

        $allHttpQuery = collect($this->parseHttpValue($this->request->only($query))->get($query, []));

        $allowed = $this->options->get($allowed)->toArray();

        foreach ($allHttpQuery as $key => $item) {
            $value = str_replace("-", "", $item);

            if (!in_array($value, $allowed) && !in_array($item, $allowed)) {
                unset($allHttpQuery[$key]);
            }
        }

        return $this->parseHttpValue($allHttpQuery->toArray());
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function build(Builder $builder): Builder
    {
        $this->options = $builder->getModel()->getOptionsFilter();
        $this->addSortsToQuery($builder);
        $this->addIncludesToQuery($builder);
        $this->addFiltersToQuery($builder);
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
                $builder->orderBy($key, $descending ? 'desc' : 'asc');
            });
    }

    /**
     * @param Builder $builder
     */
    protected function addIncludesToQuery(Builder $builder)
    {
        $includes = $this->includes->toArray();

        $builder->with($includes);
    }

    /**
     * @param Builder $builder
     */
    protected function addFiltersToQuery(Builder $builder)
    {
        // JSON and JSONB
        $this->filters->transform(function ($value, $property) use ($builder) {
            if ($builder->getModel()->hasCast($property, ['object', 'array'])) {

                $parameters = $this->flatten($value, '->');

                foreach ($parameters as $key => $parameter) {
                    $key = preg_replace('/->(\d+)/', '', $key);
                    $jsonValue[$key][] = $parameter;
                }

                return $jsonValue ?? [];
            }

            return $value;
        });


        $this->filters->each(function ($value, $property) use ($builder) {
            $this->filtersExact($builder, $value, $property);
        });
    }


    /**
     * @param        $item
     * @param string $prefix
     * @return array
     */
    private function flatten($item, $prefix = '')
    {
        $result = [];
        foreach ($item as $key => $value) {

            if (is_array($value)) {
                $result = $result + $this->flatten($value, $prefix . $key . '->');
                continue;
            }

            $result[$prefix . $key] = $value;
        }
        return $result;
    }

    /**
     * @param Builder $query
     * @param         $value
     * @param string  $property
     * @return Builder
     */
    protected function filtersExact(Builder $query, $value, string $property)
    {

        if ($query->getModel()->hasCast($property, ['object', 'array'])) {

            if (is_array($value)) {
                return $query->whereIn($property . key($value), $value);
            }

            return $query->where($property . reset($value), $value);
        }

        if (is_array($value)) {
            return $query->whereIn($property, $value);
        }

        return $query->where($property, $value);
    }

    /**
     * @param null $property
     * @return mixed
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
     * @return mixed
     */
    public function revertSort($property){

        if($this->getSort($property) === 'asc'){
            return '-'.$property;
        }

        return $property;
    }


    /**
     * @param $property
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
     * @return mixed
     */
    public function getFilter($property)
    {
        return array_get($this->filters, $property);
    }

    /*
     * @param Builder $query
     * @param         $value
     * @param string  $property
     * @return Builder
     *
    protected function filtersPartial(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            return $query->where(function (Builder $query) use ($value, $property) {
                foreach ($value as $partialValue) {
                    $query->orWhere($property, 'LIKE', "%{$partialValue}%");
                }
            });
        }
        return $query->where($property, 'LIKE', "%{$value}%");
    }
    */

}
