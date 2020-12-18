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
    | Example: '/', '/admin', '/panel'
    |
    */

    'prefix' => env('DASHBOARD_PREFIX', '/admin'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | This middleware will be assigned to every route, giving you the
    | chance to add your own middleware to this stack or override any of
    | the existing middleware. Or, you can stick with this stack.
    |
    | You can learn more here: https://laravel.com/docs/middleware
    |
    */

    'middleware' => [
        'public'  => ['web'],
        'private' => ['web', 'platform'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth Page
    |--------------------------------------------------------------------------
    |
    | The property controls the visibility of Orchid's built-in authentication pages.
    | You can disable this page and use your own set like 'Jetstream'
    | You can learn more here: https://laravel.com/docs/authentication
    |
    | If your application consists entirely of an administration panel and you need
    | the functions forgot password, two-factor authentication, registration,
    | then consider using https://github.com/orchidsoftware/fortify
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
    |--------------------------------------------------------------------------
    | Icons Path
    |--------------------------------------------------------------------------
    |
    | Provide the path from your app to your SVG icons directory.
    |
    | Example: [ 'fa' => storage_path('app/fontawesome') ]
    */

    'icons' => [],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | It are a great way to inform your users of things that are happening
    | in your application. These notifications are viewable by clicking on
    | the "notification bell" icon in the application's navigation bar.
    | The notification bell will have an unread count indicator when
    | there are unread announcements or notifications.
    |
    | By default, the interval update for one minute.
    */

    'notifications' => [
        'enabled'  => true,
        'interval' => 60,
    ],

];
