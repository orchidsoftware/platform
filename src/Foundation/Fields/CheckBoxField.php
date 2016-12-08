<?php

namespace Orchid\Foundation\Fields;

use Orchid\Foundation\Services\Field\Field;

class CheckBoxField extends Field
{
    /**
     * HTML tag.
     * @var string
     */
    protected $tag = 'checkbox';

    /**
     * The rows attribute specifies the visible height of a text area, in lines.
     * @var
     */
    protected $rows;

    /**
     * @var string
     */
    public $view = 'dashboard::fields.checkbox';

    public function create($attributes, $data = null)
    {
        if (is_null($data)) {
            $data = collect();
        }

        $attributes->put('data', $data);

        return view($this->view, $attributes);
    }
}
