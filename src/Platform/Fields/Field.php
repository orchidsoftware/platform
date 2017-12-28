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

        $attributes->put('slug', $this->getSlug($attributes));
        $attributes->put('fieldName', $this->getName($attributes));
        $attributes->put('id', $this->getId($attributes));


        $attributes->put('firstTimeRender', $firstTimeRender);

        return view($this->view, $attributes);
    }


    /**
     * @param Collection $attributes
     *
     * @return string
     */
    public function getSlug(Collection $attributes)
    {
        return str_slug($attributes->get('name'));
    }

    /**
     * @param Collection $attributes
     *
     * @return string
     */
    public function getId(Collection $attributes)
    {
        $lang = $attributes->get('lang');
        $slug = $attributes->get('slug');

        return "field-$lang-$slug";
    }

    /**
     * @param Collection $attributes
     *
     * @return string
     */
    public function getName(Collection $attributes)
    {
        $prefix = $attributes->get('prefix');
        $lang = $attributes->get('lang');
        $name = $attributes->get('name');

        if (is_null($prefix)) {
            return $lang . $name;
        }

        return $prefix . '[' . $lang . ']' . $name;
    }
}
