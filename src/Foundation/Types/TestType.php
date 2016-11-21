<?php namespace Orchid\Foundation\Types;


use Orchid\Foundation\Fields\InputField;
use Orchid\Foundation\Fields\TextAreaField;
use Orchid\Foundation\Services\Type\Type;

class TestType extends Type {

    /**
     * @var string
     */
    public $name = 'Название  например новость';


    /**
     * @var string
     */
    public $slug = 'news';


    /**
     * @var array
     */
    public $fields = [
        'name' => InputField::class,
        'text' => TextAreaField::class,
    ];

    /**
     * @var bool
     */
    public $page = true;



}