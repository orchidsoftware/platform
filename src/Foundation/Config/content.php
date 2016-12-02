<?php


return [


    /*
     * Types - an abstract pattern of behavior record
     */
    'types' => [
        \Orchid\Foundation\Types\TestType::class,
    ],


    /*
     * Available fields to form templates
     */
    'fields' => [
        'textarea' => \Orchid\Foundation\Fields\TextAreaField::class,
        'input' => \Orchid\Foundation\Fields\InputField::class,
        'tags' => \Orchid\Foundation\Fields\TagsField::class,
        'robot' => \Orchid\Foundation\Fields\RobotField::class,
    ],


    /*
     *  Available locales
     */
    'locales' => [

        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'dir' => 'ltr',
            'native' => 'English',
            'regional' => 'en_GB',
        ],

        'ru' => [
            'name' => 'Russian',
            'script' => 'Cyrl',
            'dir' => 'ltr',
            'native' => 'Русский',
            'regional' => 'ru_RU',
        ],
    ],

];
