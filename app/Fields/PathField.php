<?php

namespace Orchid\Fields;

use Orchid\Field\Field;

class PathField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.path';

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
        $attributes->put('slug', str_slug($attributes->get('name')));

        return view($this->view, $attributes);
    }
}
