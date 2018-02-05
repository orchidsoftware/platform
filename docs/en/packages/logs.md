#Error log
----------

Laravel uses for logging the popular library Monolog, ORCHID uses
A logging parser that allows you to obtain data for building and analysis.


### Application Requirements

Error log support only the daily log handler, so make sure that you log handler is set to `daily` instead of `single`:

```php
//config\app.php
return [
...

/*--------------------------------------------------------------
 | Logging Configuration
 |--------------------------------------------------------------
 | Available Settings: "single", "daily", "syslog", "errorlog"
 */
'log' => 'daily',

...
];
```

Laravel uses the [Monolog PHP logging library](https://github.com/Seldaek/monolog). This gives you a variety of powerful log handlers/formatters to utilize.
