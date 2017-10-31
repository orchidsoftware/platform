# Alert
----------
Alert - this is a one-time message will be deleted the next time.
Notifications are designed to inform about current events related to your website.

ORCHID has a convenient call and display notifications on the top of the disposable flash-data.
### Using:

```php
public function store()
{
    Alert::message('Welcome Aboard!');
    return Redirect::home();
}
```

You can also:

```php
Alert::info('Message')
Alert::success('Message')
Alert::error('Message')
Alert::warning('Message')
```



In use, it is found more keys in the session:
- 'flash_notification.message' - Message to display
- 'flash_notification.level' - A string representing the type of notification (good for applying HTML class names)

To display in the desired position requires:
```html
<div class="container">
    @include('dashboard::partials.alert')
    <p>Welcome to my website...</p>
</div>
```


### Notice dashboard

```php
$user->notify(new \Orchid\Platform\Notifications\DashboardNotification([
    'title' => 'Hello Word',
    'message' => 'New post!',
    'action' => 'https://google.com',
    'type' => 'error',
]));
```

Support type:

- info (По умолчанию)
- success
- warning
- error
