#Defender
----------

Blacklist and Whitelist

All IP addresses in those lists will no be able to access routes filtered by the blacklist filter.


`config/defender.php`

```php
/*
|--------------------------------------------------------------------------
| Black listed IP  addresses
|--------------------------------------------------------------------------
|
*/
'blacklist'  => [
    //'127.0.0.1',
],
/*
|--------------------------------------------------------------------------
| White listed IP addresses,
|--------------------------------------------------------------------------
|
*/
'whitelist'  => [
    //'127.0.0.2',
],
```

###Scanning

Scanning of dangerous files and functions in the public directory according to the signatures specified in the config `config/defender`


By default, the following file types are checked:
```php
    /*
    |--------------------------------------------------------------------------
    | File extensions that will be scanned
    |--------------------------------------------------------------------------
    |
    */
    'extensions' => [
        '.ph',
        '.php',
        '.php3',
        '.phtml',
        '.htm',
        '.htm',
        '.html',
        '.txt',
        '.js',
        '.pl',
        '.cgi',
        '.py',
        '.bash',
        '.sh',
        '.xml',
        '.ssi',
        '.inc',
        '.pm',
        '.tpl',
    ],
```

But dangerous functions are:
```php
    /*
    |--------------------------------------------------------------------------
    | Typical signs of malicious scripts
    |--------------------------------------------------------------------------
    |
    */
    'signatures' => [
        'exec',
        'passthru',
        'system',
        'shell_exec',
        'popen',
        'proc_open',
        'pcntl_exec',
        'eval',
        'base64',
        'base64_decode',
        'assert',
        'preg_replace',
        'create_function',
        'include',
        'include_once',
        'require',
        'require_once',
        'ReflectionFunction',
    ],
```

To verify, you must perform
```php
php artisan defender:scan
```

