<?php

namespace Orchid\Foundation\Types;

use Orchid\Foundation\Services\Type\Type;

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
     * @var bool
     */
    public $page = true;

    /**
     * @return array
     */
    public function setFields()
    {
        return [
            'input' => 'type:text|name:name|max:255|required|title:Название статьи|help:Упоменение',
            'textarea' =>  'name:content|max:255|required',
        ];
    }

    /**
     * @return string
     */
    public function generateForm()
    {
        $this->fields = $this->setFields();
        $this->parseFields();


        $fields = $this->fields;

        $form = '';
        foreach ($fields as $field => $config) {
            $field = config('content.fields.'.$field);
            $field = new $field;
            $field = $field->create($config);


            $form .= $field->render();
        }


        return $form;
    }
}
