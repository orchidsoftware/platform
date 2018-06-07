# Configuration file
----------

ORCHID uses the standard Laravel configuration system.
All parameters can be found in `config` directory, and the `platform.php` file is main for platform. Every setting is prompted with commentary summing it's essence.


## Headless mode

```php
'headless' => false,
```

It's obvious that platform is not able to cover all the developer work so it provides an ability to completely turn the graphical interface off.
It may be useful if you create the application with user-generated content that will not need external administration. 
It's a great solution also in case you want to use your own graphical interface (For example, if you want to embed a dashboard into your interface).

When this mode is active, ORCHID will not register your application routes and you will have to to implement all the required functionality by yourself.

## Platform address

```php
'domain' => env('DASHBOARD_DOMAIN', parse_url(config('app.url'))['host']),
```

Dashboard address plays an important role for many projects .
For example, an application may be at the address `example.com` and a dashboard is at `admin.example.com` or even at external domain.

To perform this you need to define which address must be accessed to open it. 

```php
'domain' => 'admin.example.com',
```
 
Remember that your web server parameters must be properly configured.




## Platform prefix


```php
'prefix' => env('DASHBOARD_PREFIX', 'dashboard'),
```

The system installed on the website can be easily defined by the dashboard prefix, for example it is `wp-admin` for WordPress, and it gives an opportunity to automatically search for old vulnerable versions of software and gain control over it.
 
There are other reasons but we won't speak of them in this section. 
The point is that ORCHID allows to change`dashboard` prefix to every other name, `admin` or `administrator` for example.



## Middlewares

```php
'middleware' => [
    'public'  => ['web'],
    'private' => ['web', 'dashboard'],
],
```

You may add or delete middlewares of graphical interface. 
At the moment there is two types of middlewares: `public`, that unauthorized user may access to, for example, it may be `Login` page or `Password recovery`, and `private` that may be accessed only by authorized users.


You may add as much new middlewares as you want, as example the middleware for IP whitelist filtration.



## Authorization page

```php
'auth' => [
    'display' => true,
    'image'   => '/orchid/img/background.jpg',
    //'slogan'  => '',
],
```

Authorization page has several settings like background image and your project motto. 
Also there is an ability to completely disable the embedded authorization form and implement your own with the following command:

```php
php artisan make:auth
```



## Post localization

```php
'locales' => [
    'en' => [
        'name'     => 'English',
        'script'   => 'Latn',
        'dir'      => 'ltr',
        'native'   => 'English',
        'regional' => 'en_GB',
    ],
],
```

Generic entries created with `entity` system may be localized, it means you may create the same entries in different languages; to add new language you only need to add new element to array.



## Fields

```php
'fields' => [
    'textarea'     => Orchid\Platform\Fields\Types\TextAreaField::class,
    'input'        => Orchid\Platform\Fields\Types\InputField::class,
    'list'         => Orchid\Platform\Fields\Types\ListField::class,
    'tags'         => Orchid\Platform\Fields\Types\TagsField::class,
    'robot'        => Orchid\Platform\Fields\Types\RobotField::class,
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
```

In field configuration field aliases are used to abstract away from elements used, for example, `wysiwyg` is an alias for TinyMCEField redactor. If you came to decide that the functionality of redactor you use is not enough you will only have to change it's alias to other's instead of changing it's full name in every file of your project.

[More about fields](/en/docs/field/)


## Single behaviours

```php
'single' => [
    Orchid\Press\Entities\Single\DemoPage::class,
],
```

Single entities is the many entity type that exists only in one exemplary. 
It's a great solution for creation of unique (Non-generic!) website pages.


## `Many` entities


```php
'many' => [
    Orchid\Press\Entities\Many\DemoPage::class,
],
```

Many entities are used to reduce the time spent on creation of generic data with multiple entries.
For example if you need to create some kind of catalogs or reference books which have the similar data in them.


## Standard entities

```php
'common' => [
    'user'     => Orchid\Platform\Entities\Base\UserBase::class,
    'category' => Orchid\Press\CategoryBase::class,
],
```

The platform is shipped with a basic set of CRUD commands like user creation; to alter or add new input fields the standard classes must be changed.

## User menu

```php
'menu' => [
    'header'  => 'Header menu',
    'sidebar' => 'Sidebar menu',
    'footer'  => 'Footer menu',
],
```

Menu configuration only requires key and value that will be shown to user. 
By default there are three types of menus: upper, side and lower. 
You may add or delete them if you need.

You may see an example of menu usage [there](/en/docs/tutorial_blog/#vidzhet).

## Images

```php
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
```

Attachments may process pictures creating copies of required format.


## Attachment types

```php
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
```

Attachments may be also be grouped which may be useful for example if only documents or videos are required.

## Dashboard widgets

```php
'main_widgets' => [
    Orchid\Platform\Http\Widgets\UpdateWidget::class,
],
```

Main dashboard page by default has only one widget informing about new stable software version. ORCHID is not created to solve individual problems so it cannot provide any types of metrics (For example about quantity of created posts or user visits)

You may create and add any widgets you want to view. See the "Widgets" section to find more about.


## Dashboard resources


```php
'resource' => [
    'stylesheets' => [],
    'scripts'     => [],
],
```

During your work you may need to add your own style tables or javascript scenarios globally for all the pages, so you need to add them to relevant arrays.
