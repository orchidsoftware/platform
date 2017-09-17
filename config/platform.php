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
        'slogan'  => trans('dashboard::auth/account.slogan'),
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
