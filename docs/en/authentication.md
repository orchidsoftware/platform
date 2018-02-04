# Authorization
----------


## Quick Start Guide

In the established ORCHID configuration, there already exists a built-in
page for user authorization, which is standard
to the address `/ dashboard/login`.

During the installation phase, you inherited the model in `app/User.php`, just to
be able to expand and simultaneously inform Laravel which model for authorization to use
(See the configuration file `config/auth.php`).



## Change

Authorization uses the usual Laravel input form, which requires only two parameters
`E-mail` and` Password`. In real applications, you may need flexibility,
 for example, use `ldap` or login through social networks. To do this, you need to create
 own page where you could modify it.
 
First of all, turn off our built-in authorization page, for this change the value of `display`
in the configuration file:

```php
'auth' => [
    'display' => false,
],
```
 
 
Use the built-in Laravel command to create the blanks of all necessary routes and templates
 with the command:

```php
php artisan make: auth
```

We'll add `auth` middleware to the configuration of the platform` config/platform.php`, for the correct redirects.
Please note that you must specify it before `dashboard`
```php
    'middleware' => [
        'public' => ['web'],
        'private' => ['web', 'auth', 'dashboard'],
    ],
```
