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
        'private' => ['web', 'platform'],
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
        'textarea'     => Orchid\Screen\Fields\Types\TextAreaField::class,
        'input'        => Orchid\Screen\Fields\Types\InputField::class,
        'tags'         => Orchid\Screen\Fields\Types\TagsField::class,
        'select'       => Orchid\Screen\Fields\Types\SelectField::class,
        'relationship' => Orchid\Screen\Fields\Types\RelationshipField::class,
        'place'        => Orchid\Screen\Fields\Types\PlaceField::class,
        'picture'      => Orchid\Screen\Fields\Types\PictureField::class,
        'datetime'     => Orchid\Screen\Fields\Types\DateTimerField::class,
        'checkbox'     => Orchid\Screen\Fields\Types\CheckBoxField::class,
        'wysiwyg'      => Orchid\Screen\Fields\Types\TinyMCEField::class,
        'password'     => Orchid\Screen\Fields\Types\PasswordField::class,
        'markdown'     => Orchid\Screen\Fields\Types\SimpleMDEField::class,
        'label'        => Orchid\Screen\Fields\Types\LabelField::class,
        'upload'       => Orchid\Screen\Fields\Types\UploadField::class,
        'utm'          => Orchid\Screen\Fields\Types\UTMField::class,
        'view'         => Orchid\Screen\Fields\Types\ViewField::class,
        'code'         => Orchid\Screen\Fields\Types\CodeField::class,
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
        Orchid\Platform\Http\Widgets\WelcomeWidget::class,
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
