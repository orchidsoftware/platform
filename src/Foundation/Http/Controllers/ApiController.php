<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 08.02.17
 * Time: 9:24.
 */

namespace Orchid\Foundation\Http\Controllers;

use Orchid\Foundation\Filters\BetweenFilter;
use Orchid\Foundation\Filters\ContentFilters;
use Orchid\Foundation\Filters\LikeFilters;
use Orchid\Foundation\Filters\LimitFilters;
use Orchid\Foundation\Filters\WhereFilters;
use Orchid\Foundation\Http\Requests\Request;

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

                if ($filterClass != null) {
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

            if ($filterClass != null) {
                $filter = new $filterClass($post, $column, $filtersDescriptor);
                $post = $filter->run();
            }
        }

        return $post;
    }
}
