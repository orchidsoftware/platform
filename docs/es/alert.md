# Notificaciones
----------

Las notificaciones son una manera simple de informar a un usuario sobre el estado de su aplicación. Por ejemplo, una notificación puede informar a un usuario del largo proceso que termina o un nuevo mensaje en camino. En esta sección le mostraremos cómo hacerlo funcionar en su aplicación. 

## Notificaciones flash:

La notificiación flash es una notificación desechable que será borrada en la próxima apelación. Las notificaciones son para informar directamente sobre un evento ocurrido, por ejemplo, un mensaje sobre información almacenada.

ORCHID tiene un diseño práctico de llamadas y notificaciones en la información flash disponible.


```php
public function store()
{
    Alert::message('Welcome Aboard!');
    return Redirect::home();
}
```

Puede que también le guste esto:

```php
Alert::info('Message')
Alert::success('Message')
Alert::error('Message')
Alert::warning('Message')
```

o utilice una notación más corta:

```php
alert('Message');
```


Luego de eso habrán varias claves instaladas en una sesión:
- 'flash_notification.message' - Mensaje a mostrar
- 'flash_notification.level' - El string que representa el típo de notificación

Para mostrar en un lugar en particular puede utilizar lo siguiente:
```html
<div class="container">
    @include('dashboard::partials.alert')
    <p>Welcome to my website...</p>
</div>
```

## Notificaciones en el tablero

Las notificaciones de tablero son diferentes de los mensajes flash en el sentido de que no desaparecen luego de mostrarse y pueden ser añadidos a cualquier usuario, incluso si no se encuentran en linea. Esta es otra buena forma de informar, por ejemplo, notificar a un asociado sobre una nueva tarea en la aplicación "administrador de tareas".

Necesita hacer lo siguiente para crear una notificación:
```php
$user = User::find(1);

$user->notify(new \Orchid\Platform\Notifications\DashboardNotification([
    'title' => 'Hello Word',
    'message' => 'New post!',
    'action' => 'https://google.com',
    'type' => 'error',
]));
```

Típos permitidos:

- información (Prestablecida)
- éxito
- advertencia
- error
