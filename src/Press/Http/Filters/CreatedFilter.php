<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateRange;

class CreatedFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'created_at',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return __('Date of creation');
    }

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
     * @return Field[]
     */
    public function display(): array
    {
        return [
            DateRange::make('created_at')
                ->title($this->name())
                ->value([
                    'start' => $this->request->input('created_at.start'),
                    'end'   => $this->request->input('created_at.end'),
                ]),
        ];
    }
}
