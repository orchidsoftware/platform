# System requirements
----------

This manual contains detailed system requirements for installation


## Browser Requirements

Administration panel (without additional modules),
Compatible and fully functional in all modern browsers,
supporting CSS and JavaScript (minor changes of appearance are possible).

- Microsoft Edge
- Firefox
- Opera
- Safari
- Google Chrome

The exterior is built on the most popular structure of `Bootstrap`. Recommended screen resolutions 1920 × 1080 (Full HD)


## Database Server

### MySQL

Required version of MySQL 5.7.8 or higher with InnoDB as the primary storage engine
, also requires the expansion of the PDO database.

### PostgreSQL
Requires PostgreSQL 9.3 or later.


### Mariadb
Requires Mariadb 10.3.2 or later.

### Other database servers
Some provided not so abstract from the code specific to MySQL/PostgreSQL,
as we would like to all. Running and using on other servers is possible, but may be required
change the work of some functions.

## PHP

ORCHID requires a minimum of PHP `7.0` to run and run. You also need extensions

- PHP OpenSSL extension
- PHP PDO extension
- PHP extension Mbstring
- PHP Tokenizer extension
- PHP XML Extension
- PHP GD extension
- PHP JSON extension


## Web server

ORCHID works on any web server with a version of PHP version of `7.0` or higher.

Many hosting providers offer the option of choosing a version of PHP.
The PHP version by default can be less than 7.0, so check your host's control panel,
to find out which version of PHP is currently supported, and change it to match the requirements.

If you want to create and develop ORCHID sites on your computer, you can install everything you need locally.


### Apache
     
In Laravel there is a file `public/.htaccess`, which is used to display links without specifying
front controller `index.php` in the requested address.
Before you start Laravel with the Apache server, make sure that the module `mod_rewrite` is enabled,
it is necessary for correct processing of the .htaccess file.
     
If the file `.htaccess` supplied with Laravel does not work with your Apache server, then try the alternative:

```php
Options + FollowSymLinks
RewriteEngine On

RewriteCond% {REQUEST_FILENAME}! -d
RewriteCond% {REQUEST_FILENAME}! -f
RewriteRule ^ index.php [L]
```


### Nginx

If you use Nginx, then the following directive in the configuration of your site
will send all requests to the front-controller `index.php`:

```php
location/{
    try_files $uri $uri//index.php?$query_string;
}
```


### Built-in PHP web server (for development only)

The embedded PHP web server is included as a CLI tool in PHP version 5.4.0 or later.

The PHP web server was designed to aid in the development of applications.
It can also be useful for testing or demonstrating applications,
which run in controlled environments.
It is not intended for a full-featured web server,
so it should not be used as a production server for public use.
