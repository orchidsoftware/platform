# System requirements
----------

This titorial contains a detailed system requirements for install 


## Browser support

Dashboard (without third-party modules),
is compatible with and fully functionsl in all modern browsers
that support CSS and JavaScript (Insubstantional changes in layout may occur).

- Microsoft Edge
- Firefox
- Opera
- Safari
- Google Chrome

The layout is based on the most popular `Bootstrap` structure. Recommended display resolution is 1920×1080 (Full HD)


## Database server

### MySQL

The required MySQL version is 5.7.8 or higher, with InnoDB as the main data storing mechanism
, also requires the expansion of the database PDO.

### PostgreSQL
PostgreSQL 9.3 or newer is required.


### Mariadb
Mariadb 10.3.2 or newer is required.

### Other database servers
Others servers are not so abstract from code specific for MySQL/PostgreSQL,
as some might desire. Startup and use on other servers is possible but it may require 
changes in some functions.

## PHP

ORCHID requires PHP `7.1.3` or newer for startup and work. Also the following plugins are required:

- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- GD PHP Extension

## Web server

ORCHID perfectly works at every servers with PHP `7.0` or higher.

Many hosting-providers allow to choose PHP version. 
PHP may be lower 7.0 by default, that's why you better check your host dashboard
to see which version of PHP is supported now and change it to match the requirements.

If you want to create and develop ORCHID projects at your own computeer you may install everything required locally.


### Apache
     
There is the file `public/.htaccess` in Laravel that's used to display links without defining the 
front=end controller `index.php` in requested address. 
Before you start the Laravel to work with Apache server you should make sure that the `mod_rewrite` module is active, 
it's required to correctly process the .htaccess file.
     
If the file `.htaccess` provided with Laravel doesn't work with your Apache server, try the alternative:

```php
Options +FollowSymLinks
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```


### Nginx

If you use Nginx, then the following dorective in your configuration file will 
redirect all requests to the `index.php` front-end controller:

```php
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```


### Built-in PHP server (develop only)

The Built-in PHP is included as the CLI instrument in PHP 5.4.0 and higher.

PHP web server was developed to help the development of applications. 
It also may be useful for testing or demonstrating of apps 
that are started in controlled environments.
It's not meant to be fully functional web server
that's why it should not be used as the production server for public use.
