<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Orchid\Screen\Field;
use Illuminate\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Illuminate\Support\Collection;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Dashboard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchScreen extends Screen
{
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
    public $description = 'On request: ';

    /**
     * Count of items found.
     *
     * @var int
     */
    private $total = 0;

    /**
     * @var Collection
     */
    private $results;

    /**
     * Query data.
     *
     * @param string|null $query
     *
     * @return array
     */
    public function query(string $query = null): array
    {
        $this->results = $this->search($query);
        $this->description .= $query;

        return [
            'results' => $this->results,
            'total'   => $this->total,
        ];
    }

    /**
     * @return array
     */
    public function commandBar(): array
    {
        return [

        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        $layouts = [];

        $this->results->each(function ($item) use (&$layouts) {
            $key = $item['label'];

            $layouts[$key] = Layout::view('platform::partials.result', $item);
        });

        return [

            Layout::rows([
                Field::group([
                    CheckBox::make('search')
                        ->horizontal()
                        ->placeholder('Users'),

                    CheckBox::make('search')
                        ->horizontal()
                        ->placeholder('Roles'),

                    CheckBox::make('search')
                        ->horizontal()
                        ->placeholder('Example'),

                    CheckBox::make('search')
                        ->horizontal()
                        ->placeholder('Products'),
                ]),
            ])->with(50),

            reset($layouts),
        ];
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
            'query'   => $query,
        ]);
    }

    /**
     * @param string|null $query
     *
     * @return Collection
     */
    private function search(string $query = null) : Collection
    {
        return Dashboard::getGlobalSearch()
            ->map(function (Model $model) use ($query) {

                /** @var LengthAwarePaginator $result */
                $result = $model->searchQuery($query);
                $label = $model->searchLabel();

                if ($result->total() == 0) {
                    return;
                }

                $this->total += $result->total();

                return compact('label', 'result');
            })
            ->filter();
    }
}
