# Derechos de Acceso
----------
El control de acceso basado en Roles es el desarrollo de la política de control de acceso de muestra. Los roles se forman como los objetos de marcos metodológicos de autorización de un grupo dependiendo de su aplicación específica. 

El objetivo de la formación de roles es la determinación de reglas de control de acceso que el usuario pueda comprender. Al control de acceso basado en roles se le permite variar de manera dinámica y flexible mientras trabaja el sistema de control de accesos.

El permiso es la unidad mínima de derecho que un usuario puede tener. Puede verificar si un usuario tiene un permiso con el nombre especificado.


## Usuario

En la aplicación ORCHID usualmente se le dan roles a los usuarios, no permisos (sin embargo, si existe la posibilidad). El rol está relacionado con un grupo de permisos en lugar del usuario individual.

El concepto es fácil de aprender. Generalmente, en un proceso de negocios común usted se encarga de varias docenas de permisos. También puede tener desde 10 a 100 usuarios. Ya que los usuarios no son totalemente particulares, puede divirlos en grupos lógicos de acuerdo a cómo se lleven con el programa. Estos grupos de llaman roles.

La supervisión directa de usuarios a través asignación de permisos puede ser agotadora debido a los usuarios y la pluralidad de los permisos.


- Puede agrupar uno, dos o más permisos en un rol.
- A un usuario se le puede asignar uno o varios roles.
- Un grupo de permisos que posea un usuario se calcula como la concatenación de permisos de cada rol del usuario.


Un usuaruio tiene varios sabores de manejo de roles:

```php
// Check if the user has rights
// Check is performed for both user and his role
Auth:user()->hasAccess($string);

// Get all roles of the user
Auth::user()->getRoles();

// Check if the user has a role
Auth::user()->inRole($role)

// Add a role to the user
Auth::user()->addRole($role)
```

## Los Roles

Los roles también tienen el siguiente procedimiento:

```php
// Returns all users with the role
$role->getUsers();
```


## Creación del rol de administrador

Ejecute el siguiente comando para crear un usuario con derechos supremos (en el momento de la creación):


```php
php artisan make:admin nickname email@email.com secretpassword
```


## Añadiendo permisos personalizados


Puede establecer sus propios permisos en las aplicaciones.
Haciendo uso de estos, puede implementar un acceso a funciones específicas.

Ejemplo de añadición de permisos personalizados utilizando un proveedor:

```php
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Kernel\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $permission = $this->registerPermissions();
        $dashboard->permission->registerPermissions($permission);
    }

    protected function registerPermissions()
    {
        return [
            'Modules' => [
                [
                    'slug'        => 'Analytics',
                    'description' => 'Description',
                ],
            ],

        ];
    }
}
```
