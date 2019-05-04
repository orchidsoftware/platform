<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Filters;

use Orchid\Screen\Field;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Select;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'status',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return __('Status');
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->status($this->request->get('status'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make('status')
                ->value($this->request->get('status'))
                ->options([
                    'publish' => __('Published'),
                    'draft'   => __('Draft'),
                ])
                ->empty()
                ->title($this->name())
                ->autocomplete('off'),
        ];
    }
}
