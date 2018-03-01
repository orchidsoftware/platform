<?php

namespace Orchid\Platform\Http\Layouts\User;

use Orchid\Platform\Layouts\Rows;
use Orchid\Platform\Fields\Field;

class UserRoleLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     */
	public function fields(): array
    {
		//dd($this->post);
		//dd($this->post->getContent('roles'));

		foreach ($this->post->getContent('roles') as $roles) {
			//dd($roles);
			$roleoptions[$roles->slug] =$roles->name;
		}
		//dd($role);
		//$roles=$this->post->getContent('roles');
		
		$fields[] = Field::tag('select')
			->options($roleoptions)
			->class('select2')
			->multiple()
			->name('role')
			->title('Role')
			->placeholder('Select role');
		
		
		foreach ($this->post->getContent('permission') as $keyGroup => $itemGroup) {
			
			$fields[] = Field::tag('label')
			    ->name('perm')
				->title($keyGroup);
			
			foreach ($itemGroup as $key => $item) {
				$fields[]= Field::tag('checkbox')
                   ->name("permissions[".$item['slug']."]")
                   ->value($item['active'])
                   ->placeholder($item['description']);
			}	
		
		}
		//dd($fields);
		
		/*
		return [

		'select' => Field::tag('select')
			->options($roleoptions)
			->class('select2')
			->multiple()
			->name('role')
			->title('Select tags')
			->help('Allow search bots to index page'),
			
            Field::tag('input')
                ->type('text')
                ->name('name')
				->set('value','index1')
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/users.name'))
                ->placeholder(trans('dashboard::systems/users.name')),

            Field::tag('input')
                ->type('text')
                ->name('roleselects')
                ->title(trans('dashboard::systems/users.email'))
                ->placeholder(trans('dashboard::systems/users.email')),

            Field::tag('password')
                ->name('password')
                ->title(trans('dashboard::systems/users.password'))
                ->placeholder('********'),
        ];*/
		return $fields;
    }
	
	
}