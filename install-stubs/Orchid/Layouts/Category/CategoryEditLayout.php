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
        return [
            Field::tag('input')
                ->type('text')
                ->name('category.content.name')
                ->modifyValue(function () {
                    if ($this->query->getContent('category')->exists) {
                        return $this->query->getContent('category')->term->GetContent('name');
                    }
                })
                ->max(255)
                ->require()
                ->title(__('Category name'))
                ->placeholder(__('Category name'))
                ->help(__('Category title')),

            Field::tag('input')
                ->type('text')
                ->name('category.slug')
                ->max(255)
                ->require()
                ->title(__('Slug')),

            Field::tag('select')
                ->options(function () {
                    $options = $this->query->getContent('catselect');
                    return array_replace([0=> trans('platform::systems/category.not_parrent')],$options);
                })
                ->name('category.parent_id')
                ->title(__('Parent Category')),

            Field::tag('wysiwyg')
                ->name('category.content.body')
                ->modifyValue(function () {
                    if ($this->query->getContent('category')->exists) {
                        return $this->query->getContent('category')->term->GetContent('body');
                    }
                })
                ->title(__('Description')),

        ];
    }
}
