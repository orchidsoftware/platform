<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Headless
    |--------------------------------------------------------------------------
    |
    | If the dashboard is turned true, then all routes stop working,
    | this is required if you are building your control panel or you do not need it
    |
    */

    'headless' => false,

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    |
    | Available settings
    |
    */

    'auth' => [
        'display' => true,
        'image'   => '/orchid/img/background.jpg',
        //'slogan'  => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    |
    | Localization of records
    |
    */

    'locales' => [
        'en' => [
            'name'     => 'English',
            'script'   => 'Latn',
            'dir'      => 'ltr',
            'native'   => 'English',
            'regional' => 'en_GB',
        ],
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
        'list'     => Orchid\Platform\Fields\ListField::class,
        'tags'     => Orchid\Platform\Fields\TagsField::class,
        'robot'    => Orchid\Platform\Fields\RobotField::class,
        'place'    => Orchid\Platform\Fields\PlaceField::class,
        'picture'  => Orchid\Platform\Fields\PictureField::class,
        'datetime' => Orchid\Platform\Fields\DateTimerField::class,
        'checkbox' => Orchid\Platform\Fields\CheckBoxField::class,
        'code'     => Orchid\Platform\Fields\CodeField::class,
        'wysiwyg'  => Orchid\Platform\Fields\TinyMCEField::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Single Behaviors
    |--------------------------------------------------------------------------
    |
    | Static pages
    |
    */

    'single' => [
        //App\Core\Behaviors\Single\DemoPage::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Many Behaviors
    |--------------------------------------------------------------------------
    |
    | An abstract pattern of behavior record
    |
    */

    'many' => [
        //App\Core\Behaviors\Many\DemoPost::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    'category' => \Orchid\Platform\Behaviors\Base\CategoryBase::class,

    /*
    |--------------------------------------------------------------------------
    | Available menu
    |--------------------------------------------------------------------------
    |
    | Marked menu areas
    |
    */

    'menu' => [
        'header'  => 'Header menu',
        'sidebar' => 'Sidebar menu',
        'footer'  => 'Footer menu',
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
    | Attachment types
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

    'attachment' => [
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
        Orchid\Platform\Http\Widgets\GoogleAnalyticsWidget::class,
    ],

];
