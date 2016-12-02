<?php

namespace Orchid\Foundation\Fields;

use Orchid\Foundation\Services\Field\Field;

class TagsField extends Field
{
    /**
     * HTML tag.
     * @var string
     */
    protected $tag = 'tags';


    /**
     * @var string
     */
    public $view = 'dashboard::fields.tags';

    /**
     * Create Object.
     *
     * @param null $attributes
     * @param null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($attributes, $data = null)
    {
        if (is_null($data)) {
            $data = collect();
        }
        $attributes->put('data', $data);
        return view($this->view, $attributes);
    }
}
