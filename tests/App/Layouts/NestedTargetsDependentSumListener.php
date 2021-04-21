<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Listener;
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
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * @var string
     */
    protected $asyncMethod = 'asyncSum';

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
}
