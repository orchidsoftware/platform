<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sub-Domain Routing
    |--------------------------------------------------------------------------
    |
    | This value is the "domain name" associated with your application. This
    | can be used to prevent panel internal routes from being registered
    | on subdomains that do not need access to your admin application.
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
    | route in the administration panel. Feel free to
    | change this path to anything you like.
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
    | This middleware will be assigned to every route, giving you the
    | chance to add your own middleware to this stack or override any of
    | the existing middleware. Or, you can just stick with this stack.
    |
    */

    'middleware' => [
        'public'  => ['web'],
        'private' => ['web', 'platform'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth pages
    |--------------------------------------------------------------------------
    |
    | The property controls visibility of Orchid's built-in authentication pages.
    | To customize them use this command: `php artisan ui:auth`
    |
    */

    'auth'  => true,

    /*
    |--------------------------------------------------------------------------
    | Reset password
    |--------------------------------------------------------------------------
    |
    | The property controls reset password functionality.
    |
    */

    'password_reset'  => true,

    /*
    |--------------------------------------------------------------------------
    | Default Two-Factor Authentication Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default two-factor authentication provider that
    | will be used by the framework when a user needs to be two-factor
    | authenticated.
    |
    */

    'two_factor' => \Orchid\Access\TwoFactorAuth::class,

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
    | Example: Path to your file '/views/brand/header.blade.php',
    | then its value should be 'brand.header'
    |
    */

    'template' => [
        'header' => null,
        'footer' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default configuration for attachments.
    |--------------------------------------------------------------------------
    |
    | Strategy properties for the file and storage used.
    |
    */

    'attachment' => [
        'disk'      => 'public',
        'generator' => \Orchid\Attachment\Engines\Generator::class,
    ],

    /*
    |-----------------------------------------------------------------
    | Icons Path
    |-----------------------------------------------------------------
    |
    | Provide the path from your app to your SVG icons directory.
    |
    | Example: [ 'fa' => storage_path('app/fontawesome') ]
    */

    'icons' => [],

];
