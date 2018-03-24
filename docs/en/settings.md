# Settings
----------

Settings is the simple «key-value» storage that uses thw key to access a value. These storages are usually used to store settings, create special file systems, as object caches and also in systems designed with scalability in mind.

## Adding

Pay attention that you may store not only simple type variables but arrays too. Arrays in storages are parsed to JSON that will be decoded back when a value is reqested.

To add a new value to the storage you need to do the following:
```php
use Orchid\Platform\Facades\Setting;

...

Setting::set($key,$value);
```

## Requesting

To request a value do the following:
```php
/**
* @param string|array $key
* @param string|null $default
*/
$value = Setting::get($key);
//or with default value
$value = Setting::get($key, $default);
//or helper
setting($key,$default);
```

## Deleting

To delete a value do the following:
```php
/**
* @param string|array $key
* @param string|null $default
*/
Setting::forget($key);
```



Pay attention that you may get or delete several values simultaneously, to do so you have to pass an array with key names as the first argument.

Every element is cached before it's changed by default, and if you need to get non-cached value you myst use the "getNoCache" method like this:
```php
Setting::getNoCache($key, $default = null);
```
