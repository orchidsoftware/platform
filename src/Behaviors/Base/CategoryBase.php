<?php

namespace Orchid\Platform\Behaviors\Base;

class CategoryBase
{

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'name' => 'tag:input|type:text|name:name|max:255|required|title:Name Category|help:Category title',
            'body' => 'tag:wysiwyg|name:body|max:255|required|title:Body category',
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [
            'publish_at' => 'Date of publication',
            'created_at' => 'Date of creation',
        ];
    }
}
