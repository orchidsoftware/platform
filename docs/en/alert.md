# Notifications
----------

Notifications is a simple way to inform a user about state of your application. For example, notification  can inform a user of long process finishing or new message coming. In this section we will show you how to make it work in your application.

## Flash notification:

Flash notification is a disposable notification that will be deleted at the next appeal. Notifications are to inform about directly happened event, for example message about data saving.

ORCHID has handy call and display of notifications over the disposable flash-data.


```php
public function store()
{
    Alert::message('Welcome Aboard!');
    return Redirect::home();
}
```

You may also do like this:

```php
Alert::info('Message')
Alert::success('Message')
Alert::error('Message')
Alert::warning('Message')
```

or use shorter notation:

```php
alert('Message');
```


After that there will be several keys installed in a session:
- 'flash_notification.message' - Message to be displayed
- 'flash_notification.level' - String that represents type of notification

For displaying at a particular place the following may be used:
```html
<div class="container">
    @include('platform::partials.alert')
    <p>Welcome to my website...</p>
</div>
```

## Dashboard notifications

Dashboard notifications differ from flash-messages in the fact that they don't disappear after display and can be added to any users even if they are off-line. This is another good way to inform, for example, to notify an associate about new task at the "task manager" application.

You need to do the following to create a notification:
```php
$user = User::find(1);

$user->notify(new \Orchid\Platform\Notifications\DashboardNotification([
    'title' => 'Hello Word',
    'message' => 'New post!',
    'action' => 'https://google.com',
    'type' => DashboardNotification::INFO,
]));
```

Allowed types:

- DashboardNotification::INFO (By default)
- DashboardNotification::SUCCESS
- DashboardNotification::WARNING
- DashboardNotification::ERROR
