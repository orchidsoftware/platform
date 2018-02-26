# Active links
----------

Active links is the support package that allows to easily define current address (URL) or route which is very useful in case when `active` navigation attribute needs to be added (for example in use with Bootstrap) and for actions that are only applicable when the particular route is active.

It also includes an assistant providing the info on current controller and action names.

## Helper functions

Active links with several helper functions that simplify the use without a facade.
```php
active()
is_active()
```

## The use of `active()`

You pass an array of routes or URLs you want to see as the main page and if there's some match, an `active` string will be returned to Bootstrap. Also, you may pass the user return string as the second argument.

```php
// Returns «active» if current route matches any route or resource address.
active('login', 'users/*', 'posts.*', 'pages.contact'); 

// Returns «active class» if the current route is «login» or «logout».
active(['login', 'logout'], 'active-class'); 
```

In the first example the function will return `active` if the current `login` route begins with `users /` or if the current route is `posts.create`.

Pay attention to a provided list of different argument types: you may use an URL string, an asterisk (*) URL string, and also you may use named routes.

You may use this function with your links to provide `active` state to them.

```php
<a href="{{ route('posts.index') }}" class="{{ active('posts.index') }}">
    All posts
</a>
```

You may also specify particular routes or addresses that must be checked.
```php
active(['pages/*', 'not:pages/contact'])

active(['pages.*', 'not:pages.contact'])
```

## The use of `is_active()`

This one works like `active()`: you may pass routes and addresses to it but instead it returns boolean value if current page matches the rule or not:

```php
@if (is_active('posts/*'))
    You're looking at a blog post!
@endif
```

## Additional assistants

If your routing is performed by a request controller there are two functions that allow to define current controller and available actions.
These functions will return controller name without request method. 
Below is the example of request redirected to `FooController@getBar':
```php
$controller = controller_name(); // foo

$action = action_name(); // bar
```
