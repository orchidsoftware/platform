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
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    |
    | Available settings
    |
    */
    'auth'    => [
        'display' => true,
        'image'   => '/orchid/img/background.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    |
    | Static pages
    |
    */

    'pages' => [
        //App\Core\Behaviors\Single\DemoPage::class,
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
        //App\Core\Behaviors\Many\DemoPost::class,
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
        'textarea' => Orchid\Platform\Fields\TextAreaField::class,
        'input'    => Orchid\Platform\Fields\InputField::class,
        'tags'     => Orchid\Platform\Fields\TagsField::class,
        'robot'    => Orchid\Platform\Fields\RobotField::class,
        'place'    => Orchid\Platform\Fields\PlaceField::class,
        'datetime' => Orchid\Platform\Fields\DateTimerField::class,
        'checkbox' => Orchid\Platform\Fields\CheckBoxField::class,
        'code'     => Orchid\Platform\Fields\CodeField::class,
        'wysiwyg'  => Orchid\Platform\Fields\SummernoteField::class,
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

    'locales'      => [
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
    'advertising'  => [
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
    'attachment'   => [
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

    /*
    |--------------------------------------------------------------------------
    | Dashboard Widgets
    |--------------------------------------------------------------------------
    |
    | Widgets that will be displayed on the main screen
    |
    */
    'main_widgets' => [

    ],

];
