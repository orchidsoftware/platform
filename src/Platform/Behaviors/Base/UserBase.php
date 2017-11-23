<?php

namespace Orchid\Platform\Behaviors\Base;

class UserBase
{

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules() : array
    {
        return [];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'name'     => [
                'tag'         => 'input',
                'type'        => 'text',
                'name'        => 'name',
                'max'         => 255,
                'required'    => true,
                'title'       => trans('dashboard::systems/users.name'),
                'placeholder' => trans('dashboard::systems/users.name'),
            ],
            'email'    => [
                'tag'         => 'input',
                'type'        => 'email',
                'name'        => 'email',
                'required'    => true,
                'title'       => trans('dashboard::systems/users.email'),
                'placeholder' => trans('dashboard::systems/users.email'),
            ],
            'password' => [
                'tag'         => 'password',
                'name'        => 'password',
                'title'       => trans('dashboard::systems/users.password'),
                'placeholder' => '********',
            ],
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [
            'name' => trans('dashboard::systems/users.name'),
            'email' => trans('dashboard::systems/users.email'),
            'updated_at' => trans('dashboard::common.Last edit'),
        ];
    }
}
