<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Filters;

use Orchid\Screen\Fields\Field;
use Orchid\Platform\Filters\Filter;
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
     * @var bool
     */
    public $dashboard = true;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        return $builder->status($this->request->get('status'));
    }

    /**
     * @throws \Throwable
     */
    public function display()
    {
        return Field::tag('select')
            ->name('status')
            ->value($this->request->get('status'))
            ->options($this->entity->status())
            ->title(trans('platform::common.filters.status'))
            ->autocomplete('off')
            ->hr(false);
    }
}
