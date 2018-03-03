<?php

namespace Orchid\Platform\Http\Layouts\Category;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class CategoryEditLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {

        return $fields;
    }


}
