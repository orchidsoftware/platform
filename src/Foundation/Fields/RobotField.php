<?php

namespace Orchid\Foundation\Fields;

use Orchid\Foundation\Services\Field\Field;

class RobotField extends Field
{
    /**
     * HTML tag.
     * @var string
     */
    protected $tag = 'robot';


    /**
     * @var string
     */
    public $view = 'dashboard::fields.robot';

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
