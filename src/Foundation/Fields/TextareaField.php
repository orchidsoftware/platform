<?php

namespace Orchid\Foundation\Fields;

use Orchid\Foundation\Services\Field\Field;

class TextareaField extends Field
{
    /**
     * The rows attribute specifies the visible height of a text area, in lines.
     * @var
     */
    protected $rows;

    /**
     * @var string
     */
    protected $view = 'dashboard::field.textarea';
}
