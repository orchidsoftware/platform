<?php

namespace Orchid\Field\Fields;

use Orchid\Field\Field;

class TextAreaField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.textarea';
    /**
     * HTML tag.
     *
     * @var string
     */
    protected $tag = 'textarea';
    /**
     * The rows attribute specifies the visible height of a text area, in lines.
     *
     * @var
     */
    protected $rows;

    public function create($attributes, $data = null)
    {
        if (is_null($data)) {
            $data = collect();
        }

        $attributes->put('data', $data);

        return view($this->view, $attributes);
    }
}
