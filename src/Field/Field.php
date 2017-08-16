<?php

namespace Orchid\Platform\Field;

use Illuminate\Support\Collection;

abstract class Field
{
    /**
     * View template show.
     *
     * @var
     */
    public $view;

    /**
     * @param Collection $attributes
     * @param null       $data
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function create(Collection $attributes, $data = null)
    {
        if (is_null($data)) {
            $data = collect();
        }

        $attributes->put('data', $data);
        $attributes->put('slug', str_slug($attributes->get('name')));

        return view($this->view, $attributes);
    }
}
