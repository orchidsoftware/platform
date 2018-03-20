<?php

namespace Orchid\Platform\Http\Layouts\Category;

use Orchid\Platform\Layouts\Table;
use Orchid\Platform\Fields\TD;

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
                ->title(trans('dashboard::systems/category.name'))
                ->setRender(function ($category) {
                    return '<a href="'.route('dashboard.systems.category.edit',
                        $category->id).'">'.$category->term->GetContent('name').'</a>';
                }),
            TD::name('slug')
                ->title(trans('dashboard::systems/category.slug'))
                ->setRender(function ($category) {
                    return $category->term->slug;
                }),    
            TD::name('created_at')->title(trans('dashboard::common.Created'))
                ->setRender(function ($category) {
                    return $category->term->created_at;
                }), 

        ];
    }
}
