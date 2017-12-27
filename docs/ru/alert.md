# Уведомления
----------
Уведомление — это одноразовое сообщение, которое будет удалено при следующем обращении. 
Уведомления призваны информировать о происходящих событиях, связанных с вами на сайте.

ORCHID имеет удобный вызов и отображение уведомлений по верх одноразовых flash-данных.

### Использование:

```php
public function store()
{
    Alert::message('Welcome Aboard!');
    return Redirect::home();
}
```

Вы также можете сделать:

```php
Alert::info('Message')
Alert::success('Message')
Alert::error('Message')
Alert::warning('Message')
```

При использовании, будет установлено несколько ключей в сессии:
- 'flash_notification.message' - Сообщение для отображения
- 'flash_notification.level' - Строка, представляющая тип уведомления

Для отображения в необходимом месте требуется:
```html
<div class="container">
    @include('dashboard::partials.alert')
    <p>Welcome to my website...</p>
</div>
```

### Уведомления в панели администрирования

```php
$user->notify(new \Orchid\Platform\Notifications\DashboardNotification([
    'title' => 'Hello Word',
    'message' => 'New post!',
    'action' => 'https://google.com',
    'type' => 'error',
]));
```

Поддерживаемые типы:

- info (По умолчанию)
- success
- warning
- error
