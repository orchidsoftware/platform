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
     * @param string|null $slug
     *
     * @return void
     */
    public function __construct(string $slug = null)
    {
        $this->slug = $slug ?? static::class;
    }

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
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     */
    public function getSlug(): string
    {
        return sha1($this->slug);
    }

    /**
     * @param \Orchid\Screen\Repository $repository
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Orchid\Screen\Repository
     */
    public function handle(Repository $repository, Request $request): Repository
    {
        return $repository
            ->set('first', $request->get('first'))
            ->set('second', $request->get('second'))
            ->set('sum', $request->get('first') + $request->get('second'));
    }
}
