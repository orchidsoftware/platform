<?php

namespace Orchid\Tests\App\Layouts;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;

class DependentSumListener extends Listener
{
    protected ?string $slug;

    /**
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string[]
     */
    protected $targets = [
        'first',
        'second',
    ];

    /**
     * @return \Orchid\Screen\Layout[]
     */
    protected function layouts(): array
    {
        return [
            Layout::rows([
                Input::make('sum')
                    ->title('SUM')
                    ->help('The result of adding the first argument and the second')
                    ->canSee(
                        $this->query->has('first')
                        && $this->query->get('second')
                    ),
            ]),
        ];
    }

    /**
     * @param \Orchid\Screen\Repository $repository
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Orchid\Screen\Repository
     */
    public function handle(Repository $repository, Request $request): Repository
    {
        return $repository->set('sum', $repository->get('first') + $repository->get('second'));
    }
}
