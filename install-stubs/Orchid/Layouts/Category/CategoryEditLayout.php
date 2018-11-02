<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

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
            Field::tag('input')
                ->type('text')
                ->name($categoryContent.'.name')
                ->max(255)
                ->require()
                ->title(__('Category name'))
                ->placeholder(__('Category name'))
                ->help(__('Category title')),

            Field::tag('input')
                ->type('text')
                ->name('category.term.slug')
                ->max(255)
                ->require()
                ->title(__('Slug')),

            Field::tag('select')
                ->options(function () {
                    $options = $this->query->getContent('catselect');

                    return array_replace([0=> __('Without parent')], $options);
                })
                ->name('category.parent_id')
                ->title(__('Parent Category')),

            Field::tag('wysiwyg')
                ->name($categoryContent.'.body')
                ->title(__('Description')),

        ];
    }
}
