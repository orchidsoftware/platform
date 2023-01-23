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
    | You can use the admin panel on a separate subdomain. For example:
    | 'admin.example.com'
    |
    */

    'domain'        => env('DASHBOARD_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Route Prefixes
    |--------------------------------------------------------------------------
    |
    | This prefix method can be used to specify the prefix of each route in
    | the administration panel. This allows you to easily change the path
    | to anything you like. For example: '/', '/admin', or '/panel'.
    |
    */

    'prefix'        => env('DASHBOARD_PREFIX', '/admin'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | This middleware will be assigned to every route in the administration
    | panel, giving you the ability to add your own middleware to this stack
    | or override any of the existing middleware.
    |
    | For more information on middleware, see:
    | https://laravel.com/docs/middleware
    |
    */
    'middleware'    => [
        'public'  => ['web'],
        'private' => ['web', 'platform'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    |
    | This option specifies the name of the guard that should be used for
    | authentication when accessing the administration panel. If you are
    | using a multi-auth setup, you can use this option to specify the
    | guard that should be used for administrative routes. If you are
    | not using the default guard, remember to add 'auth:guard_name'
    | to the middleware list, where 'guard_name' is the name of the
    | guard you want to use.
    |
    | You can learn more about Laravel authentication here:
    | https://laravel.com/docs/authentication
    |
    */

    'guard'         => config('auth.defaults.guard', 'web'),

    /*
    |--------------------------------------------------------------------------
    | Auth Page
    |--------------------------------------------------------------------------
    |
    | This option controls the visibility of Orchid's built-in authentication pages.
    | If you want to use your own authentication pages (e.g. with Laravel Jetstream),
    | you can disable Orchid's built-in authentication by setting this option to false.
    |
    | If your application consists entirely of an administration panel, and you need
    | the functions forgot password, two-factor authentication, registration,
    | then consider using https://github.com/orchidsoftware/fortify
    |
    */

    'auth'          => true,

    /*
    |--------------------------------------------------------------------------
    | Main Route
    |--------------------------------------------------------------------------
    |
    | This is the name of the route that will be used as the main page of the
    | application. Users will be directed to this page when they enter the
    | app or click on the app's logo or links.
    |
    | Example: 'platform.main'
    |
    */

    'index'         => 'platform.main',

    /*
    |--------------------------------------------------------------------------
    | Dashboard Resource
    |--------------------------------------------------------------------------
    |
    | Automatically connect the stored links for stylesheets and scripts in your
    | dashboard. These can be local files or external URLs.
    |
    | Example: '/css/styles.css', 'https://example.com/scripts.js'
    |
    */

    'resource'      => [
        'stylesheets' => [],
        'scripts'     => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Template view
    |--------------------------------------------------------------------------
    |
    | Templates that will be displayed in the application and used pages,
    | allowing you to customize the part of the user interface that is
    | suitable for specifying the name, logo, accompanying documents, etc.
    |
    | Example: If your file is located at '/views/brand/header.blade.php',
    | then the value for the 'header' key should be 'brand.header'
    |
    */

    'template'      => [
        'header' => '',
        'footer' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default configuration for attachments.
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify the default settings for file attachments
    | in your application. You can customize the disk and file generator used
    | for attachments.
    |
    | The `disk` option specifies the default filesystem disk where attachments
    | will be stored. The default value is 'public', but you can also specify
    | a different disk such as 's3' if you have configured one.
    |
    | The `generator` option specifies the default file generator class that
    | will be used to generate unique filenames for attachments. The default
    | value is \Orchid\Attachment\Engines\Generator::class, but you can
    | specify a different class if you have created your own custom generator.
    |
    */

    'attachment'    => [
        'disk'      => env('FILESYSTEM_DISK', 'public'),
        'generator' => \Orchid\Attachment\Engines\Generator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Icons Path
    |--------------------------------------------------------------------------
    |
    | Provide the path from your app to your SVG icons directory. This configuration
    | allows you to specify the location of your SVG icons, which can be used in
    | various parts of the application.
    |
    | Example: [ 'fa' => storage_path('app/fontawesome') ]
    |
    */

    'icons'         => [
        'orc' => \Orchid\IconPack\Path::getFolder(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | Notifications are a great way to inform your users of things that are happening
    | in your application. These notifications can be viewed by clicking on the
    | "notification bell" icon in the application's navigation bar. The notification
    | bell will have an unread count indicator when there are unread announcements
    | or notifications.
    |
    | By default, the interval for updating notifications is set to one minute.
    */

    'notifications' => [
        'enabled'  => true,
        'interval' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    |
    | This configuration option determines which models will be searchable in the
    | sidebar search feature. To be searchable, a model must have a Presenter and
    | a Scout class defined for it.
    |
    | Example:
    |
    | 'search' => [
    |     \App\Models\User::class,
    |     \App\Models\Post::class,
    | ],
    |
    */

    'search'        => [
        // \App\Models\User::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Hotwire Turbo
    |--------------------------------------------------------------------------
    |
    | Turbo Drive maintains a cache of recently visited pages.
    | This cache serves two purposes: to display pages without accessing
    | the network during restoration visits, and to improve perceived
    | performance by showing temporary previews during application visits.
    |
    */

    'turbo'         => [
        'cache' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Page
    |--------------------------------------------------------------------------
    |
    | If the request does not match any route and arguments,
    | Orchid will automatically generate its own 404 page.
    | It can be disabled if you want to declare routes on the same
    | domain and prefix or create your own page.
    |
    */

    'fallback'      => true,

    /*
    |--------------------------------------------------------------------------
    | Service Provider
    |--------------------------------------------------------------------------
    |
    | This value is a class namespace of the platform's service provider. You
    | can override it to define a custom namespace. This may be useful if you
    | want to place Orchid's service provider in a location different to
    | "app/Orchid".
    |
    */

    'provider'      => \App\Orchid\PlatformProvider::class,

];
