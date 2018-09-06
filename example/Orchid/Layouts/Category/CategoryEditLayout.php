<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Fields\Field;
use Orchid\Screen\Layouts\Rows;

class CategoryEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {
        $fields[] = Field::tag('input')
            ->type('text')
            ->name('category.content.name')
            ->modifyValue(function () {
                //dd($this->query->getContent('category')->term->GetContent('name'));
                if ($this->query->getContent('category')->exists) {
                    return $this->query->getContent('category')->term->GetContent('name');
                }
            })
            ->max(255)
            ->require()
            ->title(trans('platform::systems/category.fields.name_title'))
            ->placeholder(trans('platform::systems/category.fields.name_title'))
            ->help(trans('platform::systems/category.fields.name_help'));

        $fields[] = Field::tag('input')
            ->type('text')
            ->name('category.slug')
            ->max(255)
            ->require()
            ->title(trans('platform::systems/category.slug'));

        $fields[] = Field::tag('select')
            ->options(function () {
                return $this->query
                    ->getContent('catselect');
            })
            ->class('select2')
            ->name('category.parent_id')
            ->title(trans('platform::systems/category.parent'))
            ->placeholder(trans('platform::systems/category.parent'));

        $fields[] = Field::tag('wysiwyg')
            ->name('category.content.body')
            ->modifyValue(function () {
                if ($this->query->getContent('category')->exists) {
                    return $this->query->getContent('category')->term->GetContent('body');
                }
            })
          ->title(trans('platform::systems/category.descriptions'));

        return $fields;
    }
}
