<?php

declare(strict_types=1);

namespace Orchid\Press;

use Orchid\Platform\Fields\TD;
use Orchid\Platform\Fields\Field;
use Orchid\Press\Models\Category;

class CategoryBase
{
    /**
     * @var string
     */
    public $class = Category::class;

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
        return [
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters() : array
    {
        return [];
    }

    /**
     * @throws \Orchid\Platform\Exceptions\TypeException
     *
     * @return array
     */
    public function fields() : array
    {
        return [
            Field::tag('input')
                ->type('text')
                ->name('name')
                ->max(255)
                ->required()
                ->title(trans('dashboard::systems/category.fields.name_title'))
                ->help(trans('dashboard::systems/category.fields.name_help')),

            Field::tag('wysiwyg')
                ->name('body')
                ->max(255)
                ->required()
                ->title(trans('dashboard::systems/category.fields.body_title')),
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [
            TD::set('created_at', trans('dashboard::systems/category.date_creation')),
        ];
    }
}
