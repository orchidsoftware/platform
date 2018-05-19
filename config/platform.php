<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Brand
    |--------------------------------------------------------------------------
    |
    | Image on the main page of the panel as an icon
    | All available icons can be viewed at https://orchid.software/en/icons
    |
    */

    'logo' => 'icon-orchid text-info',

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
    | route in the administration panel. For example, you can change to '/admin'
    |
    */

    'prefix' => env('DASHBOARD_PREFIX', '/dashboard'),

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
        'slogan'  => 'platform::auth/account.slogan',
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
        'tags'         => Orchid\Platform\Fields\Types\TagsField::class,
        'select'       => Orchid\Platform\Fields\Types\SelectField::class,
        'relationship' => Orchid\Platform\Fields\Types\RelationshipField::class,
        'place'        => Orchid\Platform\Fields\Types\PlaceField::class,
        'picture'      => Orchid\Platform\Fields\Types\PictureField::class,
        'datetime'     => Orchid\Platform\Fields\Types\DateTimerField::class,
        'checkbox'     => Orchid\Platform\Fields\Types\CheckBoxField::class,
        'wysiwyg'      => Orchid\Platform\Fields\Types\TinyMCEField::class,
        'password'     => Orchid\Platform\Fields\Types\PasswordField::class,
        'markdown'     => Orchid\Platform\Fields\Types\SimpleMDEField::class,
        'label'        => Orchid\Platform\Fields\Types\LabelField::class,
        'upload'       => Orchid\Platform\Fields\Types\UploadField::class,
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

    /*
    |--------------------------------------------------------------------------
    | Dashboard .....
    |--------------------------------------------------------------------------
    |
    | ....
    |
    */
    'screens' => [
        'users' => [
            'edit'     => Orchid\Platform\Http\Screens\User\UserEdit::class,
            'list'     => Orchid\Platform\Http\Screens\User\UserList::class,
        ],
        'roles' => [
            'edit'     => Orchid\Platform\Http\Screens\Role\RoleEdit::class,
            'list'     => Orchid\Platform\Http\Screens\Role\RoleList::class,
        ],
        'comment' => [
            'edit'     => Orchid\Platform\Http\Screens\Comment\CommentEdit::class,
            'list'     => Orchid\Platform\Http\Screens\Comment\CommentList::class,
        ],
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

];
