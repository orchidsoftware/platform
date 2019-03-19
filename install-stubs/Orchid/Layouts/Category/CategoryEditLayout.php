<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TinyMCE;

class CategoryEditLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function fields(): array
    {
        $categoryContent = 'category.term.content.'.app()->getLocale();

        return [
            Input::make($categoryContent.'.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Category name'))
                ->placeholder(__('Category name'))
                ->help(__('Category title')),

            Input::make('category.term.slug')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Slug')),

            Select::make('category.parent_id')
                ->options(function () {
                    $options = $this->query->getContent('catselect');

                    return array_replace([0=> __('Without parent')], $options);
                })
                ->title(__('Parent Category')),

            TinyMCE::make($categoryContent.'.body')
                ->title(__('Description')),

        ];
    }
}
