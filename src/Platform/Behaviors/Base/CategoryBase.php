<?php

declare(strict_types=1);

namespace Orchid\Platform\Behaviors\Base;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Platform\Fields\TD;

class CategoryBase
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
                ->title('Name Category')
                ->help('Category title'),

            Field::tag('wysiwyg')
                ->name('body')
                ->max(255)
                ->require()
                ->title('Body category'),
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [
            TD::name('created_at')
                ->title('Date of creation'),
        ];
    }
}
