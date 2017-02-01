<?php namespace Orchid\Foundation\Http\Controllers\Api;


use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Filters\BetweenFilter;
use Orchid\Foundation\Filters\ContentFilters;
use Orchid\Foundation\Filters\LikeFilters;
use Orchid\Foundation\Filters\LimitFilters;
use Orchid\Foundation\Filters\WhereFilters;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Facades\Dashboard;

class PostApiController extends Controller {
    /**
     * @var array Active filters set
     */
    public $filters = [
        'eq' => WhereFilters::class,
        'count' => LimitFilters::class,
        'between' => BetweenFilter::class,
        'search' => LikeFilters::class,
        'content' => ContentFilters::class
    ];

    public function index($type, $fields) {
        $builder = $type->filters($fields);

        $posts = $builder->get();

        return response()->json($posts);
    }

    public function store(Request $request) {
        $model = $this->resolveModel($request);

        $fields = $request->get('fields');

        $builder = $this->filters($model, $fields);

        $posts = $builder->get();

        return response()->json($posts);
    }

    public function show(Post $post, Request $request)
    {
        return $this->index($post, $request);
    }

    /**
     * @param $model
     * @param $fields
     * @return mixed
     */
    public function filters($model, $fields) {
        $post = new $model;

        foreach($fields as $fieldName => $filterDescriptor) {
            foreach($filterDescriptor as $filterName => $filterParameters) {
                if(isset($this->filters[$filterName])) {
                    $filter = $this->getFilter($post, $filterName, $fieldName, $filterParameters);
                    $post = $filter->run();
                }
            }
        }

        return $post;
    }

    /**
     * @param Request $request
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
     * Создание нового фильтра
     * @param $post
     * @param $fieldName
     * @param $filterParameters
     * @return mixed
     */
    private function getFilter($post, $filterName, $fieldName, $filterParameters) {
        return new $this->filters[$filterName]($post, $fieldName, $filterParameters);
    }
}