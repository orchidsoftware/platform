<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sub-Domain Routing
    |--------------------------------------------------------------------------
    |
    | You can use the admin panel on a separate subdomain.
    |
    | Example: 'admin.example.com'
    |
    */

    'domain' => env('DASHBOARD_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Route Prefixes
    |--------------------------------------------------------------------------
    |
    | This prefix method can be used for the prefix of each
    | route in the administration panel.
    |
    | Example: '/', '/admin', '/dashboard'
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
    | Login page
    |--------------------------------------------------------------------------
    |
    | The property controls the display / hide of the page.
    | The authorization page has basic properties and does not have the
    | ability to change, use the command to change: artisan make:auth
    |
    */

    'auth'  => true,

    /*
    |--------------------------------------------------------------------------
    | Main Route
    |--------------------------------------------------------------------------
    |
    | The main page of the application is recorded as the name of the route,
    | it will be opened by users when they enter or click on logos and links.
    |
    */
    'index' => 'platform.main',

    /*
    |--------------------------------------------------------------------------
    | Dashboard Resource
    |--------------------------------------------------------------------------
    |
    | Automatically connect the stored links.
    |
    | Example: '/application.js', '/style/classic/ui.css'
    |
    */

    'resource' => [
        'stylesheets' => [],
        'scripts'     => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Template view
    |--------------------------------------------------------------------------
    |
    | Templates that will be displayed in the application and used pages,
    | allowing to customize the part of the user interface that is
    | suitable for specifying the name, logo, accompanying documents, etc.
    |
    */

    'template' => [
        'header' => 'platform::header',
        'footer' => 'platform::footer',
    ],

];
