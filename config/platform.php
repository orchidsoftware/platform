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
    | Sub-Domain Routing
    |--------------------------------------------------------------------------
    |
    | You can use the admin panel on a separate subdomain.
    | For example: 'admin.example.com'
    |
    */

    'domain' => env('DASHBOARD_DOMAIN', dashboard_domain()),

    /*
    |--------------------------------------------------------------------------
    | Route Prefixes
    |--------------------------------------------------------------------------
    |
    | This prefix method can be used for the prefix of each
    | route in the administration panel. For example, you can change to 'admin'
    |
    */

    'prefix' => env('DASHBOARD_PREFIX', 'dashboard'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Provide a convenient mechanism for filtering HTTP
    | requests entering your application.
    |
    */

    'middleware' => [
        'public'  => ['web'],
        'private' => ['web', 'dashboard'],
    ],

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
    | Locales
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
        'textarea'     => Orchid\Platform\Fields\Types\TextAreaField::class,
        'input'        => Orchid\Platform\Fields\Types\InputField::class,
        'list'         => Orchid\Platform\Fields\Types\ListField::class,
        'tags'         => Orchid\Platform\Fields\Types\TagsField::class,
        'select'       => Orchid\Platform\Fields\Types\SelectField::class,
        'relationship' => Orchid\Platform\Fields\Types\RelationshipField::class,
        'place'        => Orchid\Platform\Fields\Types\PlaceField::class,
        'picture'      => Orchid\Platform\Fields\Types\PictureField::class,
        'datetime'     => Orchid\Platform\Fields\Types\DateTimerField::class,
        'checkbox'     => Orchid\Platform\Fields\Types\CheckBoxField::class,
        'code'         => Orchid\Platform\Fields\Types\CodeField::class,
        'wysiwyg'      => Orchid\Platform\Fields\Types\TinyMCEField::class,
        'password'     => Orchid\Platform\Fields\Types\PasswordField::class,
        'markdown'     => Orchid\Platform\Fields\Types\SimpleMDEField::class,
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
        Orchid\Platform\Behaviors\Demo\Page::class,
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
        Orchid\Platform\Behaviors\Demo\Post::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Common Behaviors
    |--------------------------------------------------------------------------
    */

    'common' => [
        'user'     => Orchid\Platform\Behaviors\Base\UserBase::class,
        'category' => Orchid\Platform\Behaviors\Base\CategoryBase::class,
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
        'header'  => 'Header menu',
        'sidebar' => 'Sidebar menu',
        'footer'  => 'Footer menu',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [
        'media'      => 'public',
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
    | Grouping attachments by file extension type
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
        Orchid\Platform\Http\Widgets\UpdateWidget::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Resource
    |--------------------------------------------------------------------------
    |
    | Automatically connect the stored links. For example js and css files
    |
    */

    'resource' => [
        'stylesheets' => [],
        'scripts'     => [],
    ],

];
