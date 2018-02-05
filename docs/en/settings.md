# Settings
----------

Settings - this key-value store is the simplest data store that uses the key to access the value. Such repositories are used to store settings, create specialized file systems, as caches for objects, as well as for systems designed for scalability.

## Addition

Note that you can put in the repository not only variables of simple types, but also arrays. In the repository, the arrays will be converted to JSON, and when the value is received, it will be decoded.

To add a new value to the repository, you must use:
```php
Setting::set ($key, $value);
```

## Getting

To get the value:
```php
/ **
* @param string | array $key
* @param string | null $default
* /
Setting::get ($key, $default);
//or helper
setting ($key, $default);
```

## Removing

To delete a value:
```php
/ **
* @param string | array $key
* @param string | null $default
* /
Setting::forget ($key);
```



Note that you can get or delete several values ​​from the repository at once, for this, you must pass an array with the names of the keys to the first argument.

By default, each element is cached before it is modified, in cases where you need to get a value not from the cache, you need to use the "getNoCache"
```php
Setting::getNoCache ($key, $default = null);
```
