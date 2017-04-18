<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Install
    |--------------------------------------------------------------------------
    |
    | Setup Activation Flag
    |
    */
    'install' => env('APP_INSTALL', false),

    /*
     * Available settings
     */
    'image'   => '/orchid/img/background.jpg',

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    |
    | Static pages
    |
    */

    'pages' => [

    ],

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
    | Declared fields for user filling.
    | Be shy and add to what you need
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
        'code'     => \Orchid\Field\Fields\CodeField::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Available menu
    |--------------------------------------------------------------------------
    |
    | Marked menu areas
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
    | Localization of records
    |
    */

    'locales'     => [

        'en' => [
            'name'     => 'English',
            'script'   => 'Latn',
            'dir'      => 'ltr',
            'native'   => 'English',
            'regional' => 'en_GB',
            'required' => true,
        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | Advertising areas
    |--------------------------------------------------------------------------
    |
    | Starred areas for ad units
    |
    */
    'advertising' => [
        'top'    => 'Top banner',
        'side'   => 'Side banner',
        'footer' => 'Banner cellar',
    ],


    /*
    |--------------------------------------------------------------------------
    | Attachment types
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */
    'attachment'  => [
        'image' => [
            'png',
            'jpg',
            'jpeg',
            'gif',
        ],
        'video' => [
            'mp4',
            'mkv',
        ],
        'docs'  => [
            'doc',
            'docx',
            'pdf',
            'xls',
            'xlsx',
            'xml',
            'txt',
            'zip',
            'rar',
            'svg',
            'ppt',
            'pptx',
        ],
    ],


];
