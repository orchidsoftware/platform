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

		foreach ($this->post->getContent('selroles') as $roles) {
			//dd($roles);
			$roleoptions[$roles->slug] =$roles->name;
		}
		//dd($role);
		//$roles=$this->post->getContent('roles');
		
		$fields[] = Field::tag('select')
			->options($roleoptions)
			->class('select2')
			->multiple()
			->name('roles[]')
			->title('Role')
			->placeholder('Select role');
		
		foreach ($this->post->getContent('userpermission') as $keyGroup => $itemGroup) {
			
			$fields[] = Field::tag('label')
			    ->name('perm')
				->title($keyGroup);
			
			foreach ($itemGroup as $key => $item) {
				$fields[]= Field::tag('checkbox')
                   ->name("permissions.".str_replace(".", "_", $item['slug']))
                   ->placeholder($item['description'])
				   ->hr(false);
			}	
		}
		//dd($fields);
		
		return $fields;
    }
	
	
}
