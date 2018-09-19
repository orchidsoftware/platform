<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

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
    public function filters(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            TD::set('name', trans('platform::systems/category.name'))
                ->setRender(function ($category) {
                    return '<a href="'.route('platform.systems.category.edit',
                            $category->id).'">'.$category->delimiter.' '.$category->term->GetContent('name').'</a>';
                }),
            TD::set('slug', trans('platform::systems/category.slug'))
                ->setRender(function ($category) {
                    return $category->term->slug;
                }),
            TD::set('created_at', trans('platform::common.Created'))
                ->setRender(function ($category) {
                    return $category->term->created_at;
                }),
        ];
    }
}
