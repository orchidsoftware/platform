#Reactive links
----------

Active links are an auxiliary package that makes it easy to recognize
current address (Url) or route (Route), very useful for adding a class
`active` (for example, those used in Bootstrap), and
Different actions only if a certain route is active.
It also includes an assistant to get the current controller and action names.

## Functions assistants

Active links with several auxiliary functions that simplify the use without a facade.
```php
active ()
is_active ()
```

## Using `active ()`

You pass an array of routes or paths that you want to see, this is the current page, and if any match with this function, it returns the string `active`, for Bootstrap. In addition, you can pass a custom return string as the second argument.

```php
//Returns "active" if the current route matches any path or pathname.
active ('login', 'users/*', 'posts. *', 'pages.contact');

//Returns the "active class" if the current route is "login" or "log off".
active (['login', 'logout'], 'active-class');
```

In the first example, the function returns the string `active`, if the current path is` login`, starts with `users /` or if the name of the current route is `posts.create`.

Note that there are several types of arguments: you can use a path string, you can use a string with a wildcard (using `* '), and you can also use named routes.

You can use this function with your links to give them an active state.

```php
<a href="{{ route('posts.index') }}" class="{{ active('posts.index') }}">
    All posts
</a>
```

You can also specify specific paths or routes that need to be checked.
```php
active (['pages/*', 'not: pages/contact'])

active (['pages. *', 'not: pages.contact'])
```

## Using `is_active ()`

This works just like `active ()`, you can pass it paths and routes, but instead it returns a Boolean value if the current page matches.

```php
@if (is_active ('posts/*'))
    You're looking at a blog post!
@endif
```

## Additional assistants

To obtain the current controller and the action, two additional functions are provided if your routing is processed by the controller for the request.
These functions return the controller/action name string without the request method.
The following is an example of a request that is redirected to `FooController @ getBar ':
```php
$controller = controller_name (); //foo

$action = action_name (); //bar
```
