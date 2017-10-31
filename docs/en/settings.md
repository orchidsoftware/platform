# Settings
----------

Settings - a repository of "key-value" is the simplest data storage,
Use the key to access the value. Such storage is used to store settings,
 the creation of specialized file systems, as caches for objects as well as systems,
designed with an eye on scalability. Within ORCHID configuration implemented using a model which uses mutation.
### Using :
	

Noticed that you can not just put a simple variable type, but also in storage arrays.
The storage array will be converted to JSON, and in the preparation of its value happens to decode.


To add a new value to the repository you want to use
```php
Setting::set($key,$value);
```

For values:
```php
/**
* @param string|array $key
* @param string|null  $default
*/
Setting::get($key, $default);
//or helper
setting($key,$default);
```

To delete the value:
```php
/**
* @param string|array $key      
* @param string|null  $default
*/
Setting::forget($key);
```


Note that you can get, or remove multiple values ​​from the repository, it is necessary to pass the first has argument array with the names of the keys.


By default, each item cached until you change it if you need to get the value from the cache does not use the method of "getNoCache"
```php
Setting::getNoCache($key, $default = null);
```
