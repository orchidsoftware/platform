<?php

namespace Orchid\Foundation\Types;

use Orchid\Foundation\Services\Type\Type;
use Orchid\Foundation\Http\Forms\Posts\BasePostForm;
use Orchid\Foundation\Http\Forms\Posts\ImagesPostForm;

class TestType extends Type
{
    /**
     * @var string
     */
    public $name = 'Новости';

    /**
     * @var string
     */
    public $slug = 'news';

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
            'body' => 'tag:textarea|name:body|max:255|required|class:editor|rows:10',
            'title' => 'tag:input|type:text|name:title|max:255|required|title:Заголовок статьи|help:Упоменение',
            'description' => 'tag:textarea|name:description|max:255|required|rows:5|title:Краткое описание',
            'keywords' => 'tag:tags|name:keywords|max:255|required|title:Ключевые слова|help:Упоменение',
            'robot' => 'tag:robot|name:robot|max:255|required|title:Индексация|help:Разрешить поисковым роботам индесацию страницы',
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
        ];
    }
}
