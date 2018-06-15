<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\Category;

use Orchid\Screen\Fields\TD;
use Orchid\Screen\Layouts\Table;

class CategoryListLayout extends Table
{
    /**
     * @var string
     */
    public $data = 'category';

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters() : array
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            TD::name('name')
                ->title(trans('platform::systems/category.name'))
                ->setRender(function ($category) {
                    return '<a href="'.route('platform.systems.category.edit',
                        $category->id).'">'.$category->term->getContent('name').'</a>';
                }),
            TD::name('slug')
                ->title(trans('platform::systems/category.slug'))
                ->setRender(function ($category) {
                    return $category->term->slug;
                }),
            TD::name('created_at')->title(trans('platform::common.Created'))
                ->setRender(function ($category) {
                    return $category->term->created_at;
                }),

        ];
    }
}
