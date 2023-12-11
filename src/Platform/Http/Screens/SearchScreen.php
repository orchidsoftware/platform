<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Platform\Http\Layouts\SearchLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Contracts\Searchable;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Dashboard;
use Orchid\Support\Facades\Layout;

class SearchScreen extends Screen
{
    public const SESSION_NAME = 'orchid_search_type';

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return __('Searching results');
    }

    /**
     * Query data.
     *
     *
     * @return array
     */
    public function query(string $query): iterable
    {
        $this->description = __('On request: :query', [
            'query' => $query,
        ]);

        $searchModels = Dashboard::getSearch();

        $model = $this->getSearchModel($searchModels);

        /** @var LengthAwarePaginator $results */
        $results = $model->presenter()->searchQuery($query)->paginate();

        $results->getCollection()
            ->transform(static fn (Model $model) => $model->presenter());

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
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Apply'))
                ->icon('bs.funnel')
                ->canSee(Dashboard::getSearch()->count() > 1)
                ->method('changeSearchType'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::wrapper('platform::partials.result', [
                'radios' => SearchLayout::class,
            ]),
        ];
    }

    public function changeSearchType(Request $request)
    {
        $type = $request->get('type');

        $request->session()->put(self::SESSION_NAME, $type);
    }

    /**
     * @return Factory|View
     */
    public function compact(?string $query = null)
    {
        $total = 0;

        /** @var Searchable[] $results */
        $results = Dashboard::getSearch()
            ->transform(function (Model $model) use ($query, &$total) {
                /** @var Searchable $presenter */
                $presenter = optional($model)->presenter();

                throw_unless(is_a($presenter, Searchable::class),
                    "The presenter must have an interface 'Orchid\Screen\Contracts\Searchable'
                        for model ".get_class($model));

                $label = $presenter->label();

                /** @var LengthAwarePaginator $result */
                $result = $presenter->searchQuery($query)
                    ->paginate($presenter->perSearchShow());

                $result->getCollection()
                    ->transform(static fn (Model $model) => $model->presenter());

                if ($result->isEmpty()) {
                    return;
                }

                $total += $result->total();

                return compact('label', 'result');
            })
            ->filter();

        return view('platform::partials.result-compact', [
            'results' => $results,
            'total'   => $total,
            'query'   => $query,
        ]);
    }

    /**
     * @return mixed
     */
    private function getSearchModel(Collection $searchModels)
    {
        $class = get_class($searchModels->first());
        $type = session()->get(self::SESSION_NAME, $class);

        $model = $searchModels->filter(static fn ($model) => $model instanceof $type)->first();

        abort_if($model === null, 404, 'Required search type not found');

        return $model;
    }
}
