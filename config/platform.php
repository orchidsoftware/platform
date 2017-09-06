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
