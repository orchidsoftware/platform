<?php

namespace Orchid\Tests\App\Layouts;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;

class NestedTargetsDependentSumListener extends Listener
{
    /**
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string[]
     */
    protected $targets = [
        'father.first',
        'father.second',
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
                        $this->query->has('father.first')
                        && $this->query->get('father.second')
                    ),
            ]),
        ];
    }

    public function handle(Repository $repository, Request $request): Repository
    {
        $first = (int) $request->input('father.first');
        $second = (int) $request->input('father.second');

        return new Repository([
            'father' => [
                'first'  => $first,
                'second' => $second,
            ],
            'sum'    => $first + $second,
        ]);
    }
}
