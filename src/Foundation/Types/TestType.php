<?php

namespace Orchid\Foundation\Types;

use App\Http\Requests\TestRequest;
use Orchid\Foundation\Services\Type\Type;
use Illuminate\Validation\Rule;

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
     * Slug url /news/{name}
     * @var string
     */
    public $slugFields = 'name';


    /**
     * @var bool
     */
    public $page = true;


    /**
     * Rules Validation
     * @return array
     */
    public function rules()
    {
        return [
            'content.*.name' => 'email',
            'content.*.content' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function setFields()
    {
        return [
            'name' => 'tag:input|type:text|name:name|max:255|required|title:Название статьи|help:Упоменение',
            'content' =>  'tag:textarea|name:content|max:255|required',
        ];
    }


    /**
     * @param string $language
     * @param string $prefix
     * @return string
     */
    public function generateForm($language = 'en', $prefix = null)
    {
        $this->fields = $this->setFields();
        $this->parseFields();

        $fields = $this->fields;

        $form = '';
        foreach ($fields as $field => $config) {
            $field = config('content.fields.'.$config['tag']);
            $field = new $field;

            $config['lang'] = $language;


            if(!is_null($prefix)){
                $config['prefix'] = $prefix;
            }else{
                $config['prefix'] = $this->prefix;
            }


            $field = $field->create($config);
            $form .= $field->render();
        }


        return $form;
    }
}
