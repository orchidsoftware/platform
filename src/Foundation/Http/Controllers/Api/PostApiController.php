<?php

namespace Orchid\Foundation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Facades\Dashboard;
use Orchid\Foundation\Filters\BetweenFilter;
use Orchid\Foundation\Filters\ContentFilters;
use Orchid\Foundation\Filters\LikeFilters;
use Orchid\Foundation\Filters\LimitFilters;
use Orchid\Foundation\Filters\WhereFilters;
use Orchid\Foundation\Http\Controllers\Controller;

class PostApiController extends Controller
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

    public function index($type, $fields)
    {
        $builder = $type->filters($fields);

        $posts = $builder->get();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $model = $this->resolveModel($request);

        $builder = new $model();

        $fields = $request->get('fields');
        if ($fields != null) {
            $builder = $this->applyFieldFilters($builder, $fields);
        }

        $content = $request->get('content');

        if ($content != null) {
            $builder = $this->applyContentFilters($builder, $content);
        }

        $posts = $builder->get();

        if(($transformField = $request->get('transform')) != null) {
            $transformerClass = Dashboard::getTransformers()->get($transformField);

            if($transformerClass != null) {
                $posts = $transformerClass::transform($posts);
            }
        }

        $response = response();

        return $response->json($posts);
    }

    public function show(Post $post, Request $request)
    {
        return $this->index($post, $request);
    }

    /**
     * @param $post
     * @param $fields
     * @return mixed
     * @internal param $model
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
    private function resolveModel(Request $request)
    {
        $typeIndex = $request->get('type');

        $model = null;
        switch ($typeIndex) {
            case 'post': {
                $model = Post::class;
            } break;
            default: {
                $type = Dashboard::getTypes()->find($typeIndex);
                $model = $type->model;
            }
        }

        return $model;
    }

    /**
     * @param $post
     * @param $contentFields
     */
    private function applyContentFilters($post, $contentFields)
    {
        $contentFilters = Dashboard::getContentFilters();

        foreach ($contentFields as $fieldName => $filtersDescriptor) {
            $filterClass = $contentFilters->get($fieldName);

            if ($filterClass != null) {
                $filter = new $filterClass($post, $filtersDescriptor);
                $post = $filter->run();
            }
        }

        return $post;
    }
}
