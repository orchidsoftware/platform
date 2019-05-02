<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Filters;

use Orchid\Screen\Field;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\DateRange;
use Illuminate\Database\Eloquent\Builder;

class CreatedFilter extends Filter
{
    /**
     * The value delimiter.
     *
     * @var string
     */
    protected static $delimiter = ':';

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
