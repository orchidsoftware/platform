# Notifications
----------

Notifications are an easy way to notify the user about the status of your application. For example, they can inform the user about the end of a long process or the arrival of a new message. In this section, we'll show you how to get them to work in your application.

## One-time messages:

Flash-notification is a one-time message that will be deleted at the next access.
Notifications are intended to inform about a directly occurred event, for example, a message about saving data.

ORCHID has a convenient call and displays notifications on one-time flash data.


```php
public function store ()
{
    Alert::message ('Welcome Aboard!');
    return Redirect::home ();
}
```

You can also do:

```php
Alert::info ('Message')
Alert::success ('Message')
Alert::error ('Message')
Alert::warning ('Message')
```

or use a shorter record:

```php
alert ('Message');
```


When used, several keys will be installed in the session:
- 'flash_notification.message' - Display Image
- 'flash_notification.level' - A string representing the type of notification

To display in the required location:
```html
<div class = "container">
    @include ('dashboard::partials.alert')
    <p> Welcome to my website ... </ p>
</ div>
```

## Notifications in the administration panel

The notification in the administration panel differs from flash messages, in that they are not deleted after viewing and
can be added to any users even when they are not on the network. This is another great way to inform,
for example, for the "task manager" application, notify the employee of a new task.

To create a notification, you need:
```php
$user = User::find (1);

$user->notify (new\Orchid\Platform\Notifications\DashboardNotification ([
    'title' => 'Hello Word',
    'message' => 'New post!',
    'action' => 'https://google.com',
    'type' => 'error',
]));
```

Supported types:

- info (Default)
- success
- warning
- error
