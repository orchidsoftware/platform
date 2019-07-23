<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\View\View;
use Orchid\Platform\Dashboard;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    /**
     * Count of items found.
     *
     * @var int
     */
    private $total = 0;

    /**
     * @var Dashboard
     */
    private $dashboard;

    /**
     * SearchController constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * @param string|null $query
     *
     * @return Factory|View
     */
    public function index(string $query = null)
    {
        $results = $this->search($query);

        return view('platform::partials.result', [
            'results' => $results,
            'total'   => $this->total,
        ]);
    }

    /**
     * @param string|null $query
     *
     * @return Factory|View
     */
    public function compact(string $query = null)
    {
        $results = $this->search($query);

        return view('platform::partials.result-compact', [
            'results' => $results,
            'total'   => $this->total,
        ]);
    }

    /**
     * @param string|null $query
     *
     * @return Collection
     */
    private function search(string $query = null)
    {
        return $this->dashboard
            ->getGlobalSearch()
            ->map(function (Model $model) use ($query) {

                /** @var LengthAwarePaginator $result */
                $result = $model->searchQuery($query);
                $label = $model->searchLabel();

                if ($result->total() == 0) {
                    return;
                }

                $this->total += $result->total();
                $result = $this->generatedPresent($result);

                return compact('label', 'result');
            })
            ->filter();
    }

    /**
     * @param LengthAwarePaginator $paginator
     *
     * @return Collection
     */
    private function generatedPresent(LengthAwarePaginator $paginator): Collection
    {
        return collect($paginator->items())
            ->map(function ($item) {
                return (object) [
                    'title'    => $item->searchTitle(),
                    'subTitle' => $item->searchSubTitle(),
                    'url'      => $item->searchUrl(),
                    'avatar'   => $item->searchAvatar(),
                ];
            });
    }
}
