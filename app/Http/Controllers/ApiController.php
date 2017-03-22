<?php

namespace Orchid\Http\Controllers;

use Illuminate\Http\Request;
use Orchid\Facades\Dashboard;
use Orchid\Filters\BetweenFilter;
use Orchid\Filters\ContentFilters;
use Orchid\Filters\LikeFilters;
use Orchid\Filters\LimitFilters;
use Orchid\Filters\WhereFilters;

abstract class ApiController extends Controller
{
    /**
     * @var array Active filters set
     */
    public $filters = [
        'eq'      => WhereFilters::class,
        'count'   => LimitFilters::class,
        'between' => BetweenFilter::class,
        'search'  => LikeFilters::class,
        'content' => ContentFilters::class,
    ];

    /**
     * @param $post
     * @param $fields
     *
     * @return mixed
     */
    public function applyFieldFilters($post, $fields)
    {
        $fieldFilters = Dashboard::getFieldFilters();

        foreach ($fields as $fieldName => $filterDescriptor) {
            foreach ($filterDescriptor as $filterName => $filterParameters) {
                $filterClass = $fieldFilters->get($filterName);

                if ($filterClass !== null) {
                    $filter = new $filterClass($post, $fieldName, $filterParameters);
                    $post = $filter->run();
                }
            }
        }

        return $post;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    abstract protected function resolveModel(Request $request);

    /**
     * @param $column
     * @param $post
     * @param $contentFields
     *
     * @return mixed
     */
    protected function applyJSONFilters($column, $post, $contentFields)
    {
        $contentFilters = Dashboard::getContentFilters();

        foreach ($contentFields as $fieldName => $filtersDescriptor) {
            $filterClass = $contentFilters->get($fieldName);

            if ($filterClass !== null) {
                $filter = new $filterClass($post, $column, $filtersDescriptor);
                $post = $filter->run();
            }
        }

        return $post;
    }
}
