<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Fields\InputField;
use Orchid\Screen\Fields\SelectField;
use Orchid\Screen\Fields\TinyMCEField;
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
            InputField::make('category.content.name')
                ->type('text')
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

            InputField::make('category.slug')
                ->type('text')
                ->max(255)
                ->require()
                ->title(__('Slug')),

            SelectField::make('category.parent_id')
                ->options(function () {
                    $options = $this->query->getContent('catselect');

                    return array_replace([0=> __('Without parent')], $options);
                })
                ->title(__('Parent Category')),

            TinyMCEField::make('category.content.body')
                ->modifyValue(function () {
                    if ($this->query->getContent('category')->exists) {
                        return $this->query->getContent('category')->term->GetContent('body');
                    }
                })
                ->title(__('Description')),

        ];
    }
}
