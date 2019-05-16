<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\View\View;
use Orchid\Platform\Dashboard;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchController
{
    /**
     * @param Dashboard   $dashboard
     * @param string|null $query
     *
     * @return Factory|View
     */
    public function index(Dashboard $dashboard, string $query = null)
    {
        $results = $dashboard->getGlobalSearch()
            ->map(function ($model) use ($query) {
                $result = $model->searchQuery($query);
                $label = $model->searchLabel();

                if ($result->total() > 0) {
                    $result = $this->generatedPresent($result);

                    return compact('label', 'result');
                }
            })
            ->filter();

        return view('platform::partials.result', [
            'results' => $results,
        ]);
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
