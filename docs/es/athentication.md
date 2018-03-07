# Autenticación
----------


## Guía de autenticación breve

En la configuración instalada de ORCHID la pagína de autenticación del usuario ya está en la dirección `/dashboard/login`.

En la etapa de instalación habrá recibido el modelo en `app/User.php` para poder, más adelante, expandir un modelo de autenticación y mientras tanto definirlo para Lavarel.
(Busque en archivo de configuración `config/auth.php`)



## Modificación

La autenticación utiliza la forma de inicio de sesión Lavarel prestablecida que requiere sólo dos parámetros: `E-mail` y `Password`. En aplicaciones reales, puede ser necesaria más flexibilidad en el caso de que use `ldap` o autenticación a través de redes sociales. Así que tiene que crear su propia página que pueda modificar.
 
Primero, para apagar nuestra página de autenticación incorporada, cambiamos el valor `display` en el archivo de configuración:

```php
'auth' => [
    'display' => false,
],
```
 
 
Luego, utilizamos el comando Lavarel ya incluido para crear todas las rutas y plantillas requeridas:

```php
php artisan make:auth
```

Añadimos el middleware `auth` a la configuración de nuestra plataforma `config/platform.php` para permitir redirecciones correctas. Preste atención, este valor debe ser definido antes que `dashboard`
```php
    'middleware' => [
        'public'  => ['web'],
        'private' => ['web', 'auth', 'dashboard'],
    ],
```
