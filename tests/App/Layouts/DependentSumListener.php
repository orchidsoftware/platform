<?php

namespace Orchid\Tests\App\Layouts;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Repository;

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

    public function __construct(?string $slug = null)
    {
        $this->slug = $slug ?? static::class;
    }

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [
            Rows::make([
                Input::make('first')
                    ->title('First argument')
                    ->type('number'),

                Input::make('second')
                    ->title('Second argument')
                    ->type('number'),

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
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     */
    public function getSlug(): string
    {
        return sha1((string) $this->slug);
    }

    public function handle(Repository $repository, Request $request): Repository
    {
        return $repository
            ->set('first', $request->input('first'))
            ->set('second', $request->input('second'))
            ->set('sum', $request->input('first') + $request->input('second'));
    }
}
