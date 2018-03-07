# Enlaces activos
----------

Los enlaces activos son el paquete de soporte que permiten definir fácilmente la dirección (URL) actual o la ruta, lo cual es muy útil en caso de que el atributo de navegación `active` necesite ser añadido (por ejemplo cuando se utiliza Bootstrap) y para acciones que sólo aplican cuando la ruta particular está activa.

También incluye un asistente que provee la información sobre controladores actuales y nombres de acción.

## Funciones auxiliares

Enlaces activos con distintas funciones auxiliares que simplifican el uso sin una fachada.
```php
active()
is_active()
```

## El uso de `active()`

Pase un arreglo de rutas o URLs que desee visualizar como la página principal y si hay alguna semejanza, un string `active` será devuelto a Bootstrap. Además, puede pasar el string de devolución de usuario como segundo argumento.

```php
// Returns «active» if current route matches any route or resource address.
active('login', 'users/*', 'posts.*', 'pages.contact'); 

// Returns «active class» if the current route is «login» or «logout».
active(['login', 'logout'], 'active-class'); 
```

En el primer ejemplo la función devolverá `active` si en ese momento la ruta `login` empieza con `users /` o si la ruta presente es `posts.create`.

Preste atención a una lista prevista de diferentes tipos de argumentos: puede utilizar un string URL, un asterisco (*) string URL y también puede usar rutas nombradas.

Puede utilizar esta función con sus enlaces para proporcionar un estado `active` a estos.

```php
<a href="{{ route('posts.index') }}" class="{{ active('posts.index') }}">
    All posts
</a>
```

También puede especificar rutas particulares o direcciones que deben ser verificadas.
```php
active(['pages/*', 'not:pages/contact'])

active(['pages.*', 'not:pages.contact'])
```

## El uso de `is_active()`

Este funciona como `active()`: puede pasarle rutas y direcciones pero este devolverá valores booleanos si la página actual coincide con la regla o no:

```php
@if (is_active('posts/*'))
    You're looking at a blog post!
@endif
```

## Asistentes adicionales

Si su enrutamiento es realizado por un controlador de solicitud, existen dos funciones que permiten definir el controlador actual y las acciones disponibles.
Estas funciones devolverán el nombre del controlador sin método de solicitud.
A continuación el ejemplo de solicitud redirigida a `FooController@getBar':
```php
$controller = controller_name(); // foo

$action = action_name(); // bar
```
