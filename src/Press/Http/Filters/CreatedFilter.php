<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Filters;

use Orchid\Screen\Field;
use Orchid\Platform\Filters\Filter;
use Orchid\Screen\Fields\DateRange;
use Illuminate\Database\Eloquent\Builder;

class CreatedFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'created_at',
    ];

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('created_at', '>', $this->request->input('created_at.start'))
            ->where('created_at', '<', $this->request->input('created_at.end'));
    }

    /**
     * @return Field
     */
    public function display() : Field
    {
        return DateRange::make('created_at')
            ->title(__('Date of creation'))
            ->value([
                'start' => $this->request->input('created_at.start'),
                'end'   => $this->request->input('created_at.end'),
            ]);
    }
}
