<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\TD;
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
            TD::set('name', __('Name'))
                ->setRender(function ($category) {
                    return '<a href="'.route('platform.systems.category.edit',
                            $category->id).'">'.$category->delimiter.' '.$category->term->GetContent('name').'</a>';
                }),
            TD::set('slug', __('Slug'))
                ->setRender(function ($category) {
                    return $category->term->slug;
                }),
            TD::set('created_at', __('Created'))
                ->setRender(function ($category) {
                    return $category->term->created_at;
                }),
        ];
    }
}
