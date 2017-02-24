<?php

namespace Orchid\Foundation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Facades\Dashboard;
use Orchid\Foundation\Http\Controllers\ApiController;

class PostApiController extends ApiController
{
    /**
     * @param $type
     * @param $fields
     *
     * @return mixed
     */
    public function index($type, $fields)
    {
        $builder = $type->filters($fields);

        $posts = $builder->get();

        return response()->json($posts);
    }

    /**
     * @param Request $request
     * @return mixed
     * @internal param Post $post
     */
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
            $builder = $this->applyJSONFilters('content', $builder, $content);
        }

        $posts = $builder->get();

        if (($transformField = $request->get('transform')) != null) {
            $transformerClass = Dashboard::getTransformers()->get($transformField);

            if ($transformerClass != null) {
                $posts = $transformerClass::transform($posts);
            }
        }

        $response = response();

        return $response->json($posts);
    }

    /**
     * @param Post    $post
     * @param Request $request
     *
     * @return mixed
     */
    public function show(Post $post, Request $request)
    {
        return $this->index($post, $request);
    }

    /**
     * @param Request $request
     *
     * @return null
     */
    protected function resolveModel(Request $request)
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
}
