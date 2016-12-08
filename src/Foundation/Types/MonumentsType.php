<?php

namespace Orchid\Foundation\Types;

use Orchid\Foundation\Services\Type\Type;
use Orchid\Foundation\Http\Forms\Posts\BasePostForm;
use Orchid\Foundation\Http\Forms\Posts\ImagesPostForm;

class MonumentsType extends Type
{
    /**
     * @var string
     */
    public $name = 'Памятники архитектуры';

    /**
     * @var string
     */
    public $slug = 'monument';

    /**
     * @var string
     */
    public $icon = 'fa fa-university';

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
            'name' => 'tag:input|type:text|name:name|max:255|required|title:Название|help:Главный заголовок',
            'body' => 'tag:textarea|name:body|required|class:editor|rows:10',
            'open' => 'tag:datetime|type:text|name:open|max:255|required|title:Дата открытия|help:Открытие мероприятия состоиться',
            'close' => 'tag:datetime|type:text|name:close|max:255|required|title:Дата закрытия',
            'place' => 'tag:place|type:text|name:place|max:255|required|title:Место положение|help:Адрес на карте',
            'invalid' => 'tag:checkbox|name:invalid|placeholder:Доступная среда|default:1',
            'free' => 'tag:checkbox|name:free|placeholder:Мероприятие бесплатно|default:1',
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
            'name' => 'Название',
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
