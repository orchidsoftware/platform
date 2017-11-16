<?php

namespace Orchid\Platform\Fields;

use Illuminate\Support\Collection;
use Orchid\Platform\Exceptions\FieldRequiredAttributeException;

abstract class Field
{
    /**
     * View template show.
     *
     * @var
     */
    public $view;

    /**
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];

    /**
     * @param Collection $attributes
     * @param bool       $firstTimeRender
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws FieldRequiredAttributeException
     */
    public function create(Collection $attributes, bool $firstTimeRender)
    {
        foreach ($this->required as $attribute) {
            if (!$attributes->offsetExists($attribute)) {
                throw new FieldRequiredAttributeException('Field must have the following attribute: ' . $attribute);
            }
        }

        $attributes->put('slug', str_slug($attributes->get('name')));
        $attributes->put('firstTimeRender', $firstTimeRender);

        return view($this->view, $attributes);
    }
}
