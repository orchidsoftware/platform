<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\Category;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class CategoryEditLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Orchid\Platform\Exceptions\TypeException
     *
     * @return array
     */
    public function fields(): array
    {
        $fields[] = Field::tag('input')
                ->type('text')
                ->name('category.content.name')
                ->modifyValue(function () {
                    return $this->query->getContent('category')->term->getContent('name');
                })
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/category.fields.name_title'))
                ->placeholder(trans('dashboard::systems/category.fields.name_title'))
                ->help(trans('dashboard::systems/category.fields.name_help'));

        $fields[] = Field::tag('input')
                ->type('text')
                ->name('category.term.slug')
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/category.slug'));

        $fields[] = Field::tag('select')
                ->options(function () {
                    return $this->query
                        ->getContent('catselect');
                })
                ->modifyValue(function () {
                    $parent_id = $this->query->getContent('category')->parent_id;

                    return  [$parent_id => $this->query->getContent('catselect')[$parent_id]];
                })
                ->class('select2')
                ->name('category.parent_id')
                ->title(trans('dashboard::systems/category.parent'))
                ->placeholder(trans('dashboard::systems/category.parent'));

        $fields[] = Field::tag('wysiwyg')
                ->name('category.content.body')
                ->modifyValue(function () {
                    return $this->query->getContent('category')->term->getContent('body');
                })
                ->title(trans('dashboard::systems/category.descriptions'));

        return $fields;
    }
}
