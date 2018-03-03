<?php

namespace Orchid\Platform\Http\Layouts\User;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class UserRoleLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {

        $fields[] = Field::tag('select')
            ->options(function () {
                return $this->query
                    ->getContent('roles')
                    ->pluck('name', 'slug');
            })
            ->modifyValue(function () {
                return $this->query
                    ->getContent('roles')
                    ->where('active', true)
                    ->pluck('name', 'slug')
                    ->toArray();
            })
            ->class('select2')
            ->multiple()
            ->name('roles[]')
            ->title('Role')
            ->placeholder('Select role');


        foreach ($this->query->getContent('permission') as $group => $items) {

            $fields[] = Field::tag('label')
                ->name($group)
                ->title($group);

            foreach ($items as $item) {

                $fields[] = Field::tag('checkbox')
                    ->placeholder($item['description'])
                    ->modifyName("permissions." . base64_encode($item['slug']))
                    ->modifyValue(function () use ($item) {
                        return (int) $item['active'];
                    })
                    ->hr(false);
            }
        }


        return $fields;
    }


}
