<?php

namespace Orchid\Platform\Http\Layouts\Role;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class RoleEditLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {
        $fields[] =  Field::tag('input')
                ->type('text')
                ->name('role.name')
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/roles.name'))
                ->placeholder(trans('dashboard::systems/roles.name'))
                ->help(trans('dashboard::systems/roles.name_help'));
                
        $fields[] =  Field::tag('input')
                ->type('text')
                ->name('role.slug')
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/roles.slug'))
                ->placeholder(trans('dashboard::systems/roles.slug'))
                ->help(trans('dashboard::systems/roles.slug_help'));
        
        $fields[] = Field::tag('row')
                ->name('style')
                ->styles('.row.cols-3 .form-group {flex-basis: 33.33%;margin-bottom: 5px;}');

        foreach ($this->query->getContent('permission') as $group => $items) {

            $fields[] = Field::tag('label')
                ->name($group)
                ->title(trans('dashboard::permission.main.'.strtolower($group)))
                ->hr(false);
                
            $fields[] = Field::tag('row')
                ->name('row')
                ->div('div')
                ->class('row justify-content-start cols-3 no-gutter ml-4');
                
            foreach ($items as $item) {

                $fields[] = Field::tag('checkbox')
                    ->placeholder($item['description'])
                    ->modifyName("permissions." . base64_encode($item['slug']))
                    ->modifyValue(function () use ($item) {
                        return (int) $item['active'];
                    })
                    ->hr(false);
            }
            
            $fields[] = Field::tag('row')
                ->name('closediv')
                ->enddiv('div')
                ->hr(true);
            
        }

        return $fields;
    }


}
