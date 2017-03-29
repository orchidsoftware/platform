<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Install
    |--------------------------------------------------------------------------
    |
    | An abstract pattern of behavior record
    |
    */
    'install' => env('APP_INSTALL', false),

    /*
     * Available settings
     */
    'image' => '/orchid/img/background.jpg',

    /*
    |--------------------------------------------------------------------------
    | Types
    |--------------------------------------------------------------------------
    |
    | An abstract pattern of behavior record
    |
    */

    'types' => [
        //App\Types\DemoType::class,
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
        'input'    => \Orchid\Field\Fields\InputField::class,
        'tags'     => \Orchid\Field\Fields\TagsField::class,
        'robot'    => \Orchid\Field\Fields\RobotField::class,
        'place'    => \Orchid\Field\Fields\PlaceField::class,
        'datetime' => \Orchid\Field\Fields\DateTimerField::class,
        'checkbox' => \Orchid\Field\Fields\CheckBoxField::class,
        'path'     => \Orchid\Field\Fields\PathField::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Available menu
    |--------------------------------------------------------------------------
    |
    | Description
    |
    */

    'menu' => [
        'header'  => 'Top Menu',
        'sidebar' => 'Sidebar Menu',
        'footer'  => 'Footer Menu',
    ],

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    |
    | Image processing 100x150x75
    | 100 - integer width
    | 150 - integer height
    | 75  - integer quality
    |
    */

    'images' => [
        'low'    => [
            'width'   => '50',
            'height'  => '50',
            'quality' => '50',
        ],
        'medium' => [
            'width'   => '600',
            'height'  => '300',
            'quality' => '75',
        ],
        'high'   => [
            'width'   => '1000',
            'height'  => '500',
            'quality' => '95',
        ],
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
            'name'     => 'English',
            'script'   => 'Latn',
            'dir'      => 'ltr',
            'native'   => 'English',
            'regional' => 'en_GB',
            'required' => true,
        ],

    ],

];
