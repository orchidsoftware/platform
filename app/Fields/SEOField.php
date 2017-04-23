<?php

namespace Orchid\Fields;

use Orchid\Field\Field;

class SEOField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.seo';

    /**
     * Create Object.
     *
     * @param null $attributes
     * @param null $data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($attributes, $data)
    {
        dd($attributes, $data);

        return view($this->view, $attributes);
    }
}
