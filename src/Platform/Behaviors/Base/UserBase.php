<?php

declare(strict_types=1);

namespace Orchid\Platform\Behaviors\Base;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Platform\Fields\TD;
use Orchid\Platform\Http\Filters\RoleFilter;

class UserBase
{
    /**
     * @var int
     */
    public $chunk = 4;

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules() : array
    {
        return [];
    }

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters() : array
    {
        return [
            RoleFilter::class,
        ];
    }

    /**
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields() : array
    {
        return [

            Field::tag('input')
                ->type('text')
                ->name('name')
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/users.name'))
                ->placeholder(trans('dashboard::systems/users.name')),

            Field::tag('input')
                ->type('email')
                ->name('email')
                ->require()
                ->title(trans('dashboard::systems/users.email'))
                ->placeholder(trans('dashboard::systems/users.email')),

            Field::tag('password')
                ->name('password')
                ->title(trans('dashboard::systems/users.password'))
                ->placeholder('********'),
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [
            TD::name('name')->title(trans('dashboard::systems/users.name')),
            TD::name('email')->title(trans('dashboard::systems/users.email')),
            TD::name('updated_at')->title(trans('dashboard::common.Last edit')),
        ];
    }
}
