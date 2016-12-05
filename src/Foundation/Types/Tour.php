<?php

namespace Orchid\Foundation\Types;

use Orchid\Foundation\Services\Type\Type;
use Orchid\Foundation\Http\Forms\Posts\SeoPostForm;
use Orchid\Foundation\Http\Forms\Posts\BasePostForm;
use Orchid\Foundation\Http\Forms\Posts\ImagesPostForm;

class Tour extends Type
{
    /**
     * @var string
     */
    public $name = 'Туры';

    /**
     * @var string
     */
    public $slug = 'tour';

    /**
     * Slug url /news/{name}.
     * @var string
     */
    public $slugFields = 'name';

    /**
     * Rules Validation.
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'sometimes|integer|unique:posts',
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function setFields()
    {
        return [
            'name' => 'tag:input|type:text|name:name|max:255|required|title:Название статьи|help:Упоменение',
            'body' =>  'tag:textarea|name:body|max:255|required|class:editor|rows:10',
            'city' => 'tag:input|type:text|name:city|max:255|required|title:Населённый пункт|help:Упоменение',
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid()
    {
        return [
            'name' => 'Название новости',
            'publish' => 'Дата публикации',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * @return array
     */
    public function setModules()
    {
        return [
            BasePostForm::class,
            ImagesPostForm::class,
            SeoPostForm::class,
        ];
    }
}
