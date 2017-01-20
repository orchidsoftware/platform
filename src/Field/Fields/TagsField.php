<?php

namespace Orchid\Field\Fields;

use Orchid\Field\Field;

class TagsField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.tags';
    /**
     * HTML tag.
     *
     * @var string
     */
    protected $tag = 'tags';

    /**
     * Create Object.
     *
     * @param null $attributes
     * @param null $data
     *
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
