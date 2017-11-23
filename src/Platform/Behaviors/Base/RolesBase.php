<?php

namespace Orchid\Platform\Behaviors\Base;

class RolesBase
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
        return [];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [];
    }
}
