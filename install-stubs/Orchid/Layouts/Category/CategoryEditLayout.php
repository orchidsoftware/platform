<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\InputField;
use Orchid\Screen\Fields\SelectField;
use Orchid\Screen\Fields\TinyMCEField;

class CategoryEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     * @throws \Throwable
     */
    public function fields(): array
    {
        $categoryContent = 'category.term.content.'.app()->getLocale();

        return [
            InputField::make($categoryContent.'.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Category name'))
                ->placeholder(__('Category name'))
                ->help(__('Category title')),

            InputField::make('category.term.slug')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Slug')),

            SelectField::make('category.parent_id')
                ->options(function () {
                    $options = $this->query->getContent('catselect');

                    return array_replace([0=> __('Without parent')], $options);
                })
                ->title(__('Parent Category')),

            TinyMCEField::make($categoryContent.'.body')
                ->title(__('Description')),

        ];
    }
}
