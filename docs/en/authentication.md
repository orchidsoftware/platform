# Authentication
----------


## Quick authentication guide

In the installed ORCHID configuration the users authentication page is already there at the `/dashboard/login` address.


![Auth](https://orchid.software/img/ui/auth.png)

At the installation stage you have inherited the model in `app/User.php` to further be able to  expand an authentication model and in the meantime to define it for Laravel.
(Look in the configuration file `config/auth.php`).



## Modification

Authentication uses the default Laravel login form that requires only two parameters `E-mail` and `Password`. In real applications more flexibility may be necessary in case you use `ldap` or authentication through social networks. So you have to create your own page you could modify. 
 
First, to turn our embedded authentication page off, we change the `display` value in the configuration file:

```php
'auth' => [
    'display' => false,
],
```
 
 
Then, we use the built-in Laravel command to create all the required routes and templates:

```php
php artisan make:auth
```

We add `auth` middleware to our platform configuration `config/platform.php` to allow correct redirections.
Pay attention that this value must be defined before `platform`
```php
    'middleware' => [
        'public'  => ['web'],
        'private' => ['web', 'auth', 'platform'],
    ],
```
