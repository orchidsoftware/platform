# Active
----------

Active links - is an auxiliary package that makes it easy to recognize
  current path (Url) or route (Route), very useful for adding a class
  "Active" (for example, those used in the Bootstrap), as well as the implementation of
  various actions only if a particular route is active.
It also includes a helper to get the current controller and action names.

## Using Active
----------
### Helper functions

Active ships with a couple of helper functions which make it easy to use without the facade or creating an instance of your own.

```php
active()
is_active()
```

### Using `active()`

You pass an array of routes or paths you want to see are the current page, and if any match this function will return the string `active`, for Bootstrap. Alternatively, you can pass a custom return string as the second argument.

```php
// Returns 'active' if the current route matches any path or route name.
active('login', 'users/*', 'posts.*', 'pages.contact'); 

// Returns 'active-class' if the current route is 'login' or 'logout'.
active(['login', 'logout'], 'active-class'); 
```

In the first example, the function will return the string `active` if the current path is `login`, starts with `users/` or if the name of the current route is `posts.create`.

Do note that a number of argument types are provided: you can use a path string, you can use a path string with a wildcard (using the `*`) and you can also use named routes.

You can use this function with your links to give them an active state.

```php
<a href="{{ route('posts.index') }}" class="{{ active('posts.index') }}">
    All posts
</a>
```

You can also provide certain paths or routes to be exuded when being considered.

```php
active(['pages/*', 'not:pages/contact'])

active(['pages.*', 'not:pages.contact'])
```

### Using `is_active()`

This works much the same as `active()`, you can pass the paths and routes to it but instead it will return a boolean if the current page matches. 

```php
@if (is_active('posts/*'))
    You're looking at a blog post!
@endif
```

### Additional helpers

Two additional functions are provided to get the current controller and action, if your routing is being handled by a controller for a request. These functions will return the lowercase controller/action name, without the method of the request. Here is an example for a request that is routed to `FooController@getBar':

```php
$controller = controller_name(); // foo

$action = action_name(); // bar
```

