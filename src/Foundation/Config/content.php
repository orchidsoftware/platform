<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Types
    |--------------------------------------------------------------------------
    |
    | An abstract pattern of behavior record
    |
    */

    'types' => [
        \Orchid\Foundation\Types\TestType::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Available fields to form templates
    |--------------------------------------------------------------------------
    |
    | Description
    |
    */

    'fields' => [
        'textarea' => \Orchid\Field\Fields\TextAreaField::class,
        'input' => \Orchid\Field\Fields\InputField::class,
        'tags' => \Orchid\Field\Fields\TagsField::class,
        'robot' => \Orchid\Field\Fields\RobotField::class,
        'place' => \Orchid\Field\Fields\PlaceField::class,
        'datetime' => \Orchid\Field\Fields\DateTimerField::class,
        'checkbox' => \Orchid\Field\Fields\CheckBoxField::class,
        'path' => \Orchid\Field\Fields\PathField::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    |
    | Description
    |
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
