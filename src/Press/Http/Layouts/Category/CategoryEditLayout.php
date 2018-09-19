<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Layouts\Category;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class CategoryEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function fields(): array
    {
        return [
            Field::tag('input')
                ->type('text')
                ->name('category.content.name')
                ->modifyValue(function () {
                    return $this->query->getContent('category')->term->getContent('name');
                })
                ->max(255)
                ->require()
                ->title(trans('platform::systems/category.fields.name_title'))
                ->placeholder(trans('platform::systems/category.fields.name_title'))
                ->help(trans('platform::systems/category.fields.name_help')),

            Field::tag('input')
                ->type('text')
                ->name('category.term.slug')
                ->max(255)
                ->require()
                ->title(trans('platform::systems/category.slug')),

            Field::tag('select')
                ->options(function () {
                    return $this->query
                        ->getContent('catselect');
                })
                ->modifyValue(function () {
                    $parent_id = $this->query->getContent('category')->parent_id;

                    return  [$parent_id => $this->query->getContent('catselect')[$parent_id]];
                })
                ->name('category.parent_id')
                ->title(trans('platform::systems/category.parent'))
                ->placeholder(trans('platform::systems/category.parent')),

            Field::tag('wysiwyg')
                ->name('category.content.body')
                ->modifyValue(function () {
                    return $this->query->getContent('category')->term->getContent('body');
                })
                ->title(trans('platform::systems/category.descriptions')),
        ];
    }
}
