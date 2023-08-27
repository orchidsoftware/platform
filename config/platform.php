<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Sub-Domain Routing
     |--------------------------------------------------------------------------
     |
     | This value represents the "domain name" associated with your application. This
     | can be utilized to prevent dashboard internal routes from being registered
     | on subdomains that do not require access to your admin application.
     |
     | For instance, you can use the admin dashboard on a separate subdomain like
     | 'admin.example.com'.
     |
     */

    'domain' => env('DASHBOARD_DOMAIN', null),

    /*
     |--------------------------------------------------------------------------
     | Route Prefixes
     |--------------------------------------------------------------------------
     |
     | This prefix method can be used to specify the prefix of every route in
     | the administrator dashboard. This way, you can easily change the path
     | to a URL you find more appropriate. For instance: '/', '/admin', or '/panel'.
     |
     */

    'prefix' => env('DASHBOARD_PREFIX', '/admin'),

    /*
     |--------------------------------------------------------------------------
     | Middleware
     |--------------------------------------------------------------------------
     |
     | This middleware will be assigned to every route in the administration
     | dashboard. You can add your custom middleware to this stack.
     |
     | For more information on middleware, please refer to:
     | https://laravel.com/docs/middleware
     |
     */

    'middleware' => [
        'public'  => ['web', 'cache.headers:private;must_revalidate;etag'],
        'private' => ['web', 'platform', 'cache.headers:private;must_revalidate;etag'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    |
    | This option specifies the name of the guard that should be used for
    | authentication when accessing the administration dashboard. If you are
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

    'guard' => config('auth.defaults.guard', 'web'),

    /*
     |--------------------------------------------------------------------------
     | Authentication Page
     |--------------------------------------------------------------------------
     |
     | This option controls the visibility of Orchid's built-in authentication pages.
     | If you wish to use your own authentication pages (e.g., with Laravel Jetstream),
     | you can disable Orchid's built-in authentication by setting this option to false.
     |
     | If your application consists entirely of an administration dashboard, and you need
     | the following functions: forgot password, two-factor authentication, registration,
     | please consider using https://github.com/orchidsoftware/fortify.
     |
     */

    'auth' => true,

    /*
     |--------------------------------------------------------------------------
     | Main Route
     |--------------------------------------------------------------------------
     |
     | This route is the starting page of the dashboard application. Users will be
     | redirected to this page when they enter the dashboard or click on the
     | dashboard's logo or links.
     |
     | Example: 'platform.main'
     |
     */

    'index' => 'platform.main',

    /*
     |--------------------------------------------------------------------------
     | User Profile Route
     |--------------------------------------------------------------------------
     |
     | This route is used to access the user profile page. It will be opened by
     | users when they want to view or edit their profile information.
     |
     */

    'profile' => 'platform.profile',

    /*
     |--------------------------------------------------------------------------
     | Dashboard Resource
     |--------------------------------------------------------------------------
     |
     | This option is used to store links for stylesheets and scripts automatically
     | connected to your dashboard. These can be local files or external URLs.
     |
     | Example: '/css/styles.css', 'https://example.com/scripts.js'
     |
     */

    'resource' => [
        'stylesheets' => [],
        'scripts'     => [],
    ],

    /*
     |--------------------------------------------------------------------------
     | Vite Resource
     |--------------------------------------------------------------------------
     |
     | Within the 'vite' associative array, specify input files to be parsed by
     | Vite by providing specific paths to JS and CSS assets. Here is an example:
     |
     | Example: ['resources/css/app.css', 'resources/js/app.js']
     |
     */

    'vite' => [],

    /*
     |--------------------------------------------------------------------------
     | Template View
     |--------------------------------------------------------------------------
     |
     | This configuration option is utilized to determine which templates will be displayed
     | in the application and used on pages. It permits you to customize the part of
     | the user interface that is suitable for specifying the name, logo, accompanying
     | documents, and so on.
     |
     | Example: If your file exists at '/views/brand/header.blade.php', the value for
     | the 'header' key should be 'brand.header'.
     |
     */

    'template' => [
        'header' => '',
        'footer' => '',
    ],

    /*
     |--------------------------------------------------------------------------
     | Default Attachment Configuration
     |--------------------------------------------------------------------------
     |
     | This option allows you to specify the default settings for file attachments
     | in your application. You can customize the disk and file generator used
     | for attachments.
     |
     | The 'disk' option specifies the default filesystem disk where attachments
     | will be stored. The default value is 'public', but you can also specify
     | a different disk such as 's3' if you have configured one.
     |
     | The 'generator' option specifies the default file generator class that
     | will be used to generate unique filenames for attachments. The default
     | value is \Orchid\Attachment\Engines\Generator::class, but you can
     | specify a different class if you have created your own custom generator.
     |
     */

    'attachment' => [
        'disk'      => env('DASHBOARD_FILESYSTEM_DISK', 'public'),
        'generator' => \Orchid\Attachment\Engines\Generator::class,
    ],

    /*
     |--------------------------------------------------------------------------
     | Icons Path
     |--------------------------------------------------------------------------
     |
     | Provide the path from your app to your SVG icons directory. This configuration
     | permits you to specify the location of your SVG icons, which can be used in
     | various parts of the application.
     |
     | Example: ['fa' => storage_path('app/fontawesome')]
     |
     */

    'icons' => [
        'bs'  => \Orchid\Support\BootstrapIconsPath::getFolder(),
    ],

    /*
     |--------------------------------------------------------------------------
     | Notifications
     |--------------------------------------------------------------------------
     |
     | Notifications are an excellent way to inform your users about what is
     | happening in your application. These notifications can be viewed by
     | clicking on the notification bell icon in the application's navigation bar.
     | The notification bell will have an unread count indicator when there are
     | unread announcements or notifications.
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

    'search' => [
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

    'turbo' => [
        'cache'   => true,
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

    'fallback' => true,

    /*
    |--------------------------------------------------------------------------
    | Workspace
    |--------------------------------------------------------------------------
    |
    | The workspace option sets the template that wraps the content of the screens.
    | It determines whether the entire user screen will be used or whether
    | the content will be compressed to a fixed width.
    |
    | Options: 'platform::workspace.compact', 'platform::workspace.full'
    |
    */

    'workspace' => 'platform::workspace.compact',

    /*
    |--------------------------------------------------------------------------
    | Prevents Abandonment
    |--------------------------------------------------------------------------
    |
    | This option determines whether the Prevents Abandonment feature is enabled
    | or disabled for the application.
    |
    */

    'prevents_abandonment' => true,

    /*
     |--------------------------------------------------------------------------
     | Service Provider
     |--------------------------------------------------------------------------
     |
     | This value is a class namespace of the platform's service provider. You
     | can override it to define a custom namespace. This may be useful if you
     | want to place Orchid's service provider in a location different from
     | "app/Orchid".
     |
     */

    'provider' => \App\Orchid\PlatformProvider::class,

];
