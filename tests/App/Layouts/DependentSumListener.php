<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class DependentSumListener extends Listener
{
    /**
     * @var string|null
     */
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
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * @var string
     */
    protected $asyncMethod = 'asyncSum';

    /**
     * @param string|null $slug
     */
    public function __construct(string $slug = null)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug ?? parent::getSlug();
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
}
