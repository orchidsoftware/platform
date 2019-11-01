<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Platform\Http\Layouts\SearchLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Dashboard;

class SearchScreen extends Screen
{
    public const SESSION_NAME = 'orchid_search_type';

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Searching results';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description;

    /**
     * Count of items found.
     *
     * @var int
     */
    private $total = 0;

    /**
     * Query data.
     *
     * @param string $query
     *
     * @return array
     */
    public function query(string $query): array
    {
        $this->description = __('On request: :query', [
            'query' => $query,
        ]);

        $searchModels = Dashboard::getGlobalSearch();

        $model = $this->getSearchModel($searchModels);

        /** @var LengthAwarePaginator $results */
        $results = $model->searchQuery($query)->paginate();

        return [
            'query'   => $query,
            'model'   => $model,
            'results' => $results,
            'total'   => $results->total(),
        ];
    }

    /**
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Apply'))
                ->icon('icon-filter')
                ->method('changeSearchType'),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::wrapper('platform::partials.result', [
                'radios' => SearchLayout::class,
            ]),
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeSearchType(Request $request)
    {
        $type = $request->get('type');

        $request->session()->put(self::SESSION_NAME, $type);

        return back();
    }

    /**
     * @param string|null $query
     *
     * @return Factory|View
     */
    public function compact(string $query = null)
    {
        $results = Dashboard::getGlobalSearch()
            ->map(function (Model $model) use ($query) {

                /** @var LengthAwarePaginator $result */
                $result = $model->searchQuery($query)->paginate(3);
                $label = $model->searchLabel();

                if ($result->total() === 0) {
                    return;
                }

                $this->total += $result->total();

                return compact('label', 'result');
            })
            ->filter();

        return view('platform::partials.result-compact', [
            'results' => $results,
            'total'   => $this->total,
            'query'   => $query,
        ]);
    }

    /**
     * @param Collection $searchModels
     *
     * @return mixed
     */
    private function getSearchModel(Collection $searchModels)
    {
        $class = get_class($searchModels->first());
        $type = $this->request->session()->get(self::SESSION_NAME, $class);

        $model = $searchModels->filter(static function ($model) use ($type) {
            return $model instanceof $type;
        })->first();

        abort_if(is_null($model), 404, 'Required search type not found');

        return $model;
    }
}
