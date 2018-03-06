# Derechos de Acceso
----------
Role-based access control is the development of sample access control policy. A role forms as the objects of authorization frameworks group depending on their specific application.

El control de acceso basado en Roles es el desarrollo de la política de control de acceso de muestra. Los roles se forman como los objetos de marcos metodológicos de autorización de un grupo dependiendo de su aplicación específica. 

The formation of roles is aimed at the determination of user-understandable access control rules.  Role-based access control is allowed to vary dynamically and flexibly during the work of access control system.

El objetivo de la formación de roles es la determinación reglas de control de acceso que el usuario pueda compender. Al control de acceso basado en los roles se le permite variar de manera dinámica y fléxible mientras trabaja el sistema de control de accesos.

Permission is the least unit of right that user can have. You can check if a user has a permission with specified name.

El permiso es la unidad mínima de derecho que un usuario puede tener. Puede verificar si un usuario tiene un permiso con el nombre especificado.


## Usuario

In the ORCHID application users are usually given roles, not permissions (although, such possibility exists). The role related to a set of permissions rather than individual user. 

En la aplicación ORCHID usualemente se le entregan roles a los usuarios, no permiso (sin embargo, si existe la posibilidad). El rol está relacionado con un grupo de permisos en lugar del usuario individual.

The concept is easy-to-learn. Usually, in a common business process you manage several dozens of permissions. Also, you can have from 10 to 100 users. While the users are not fully particular, you can divide them into logical groups acording to how they deal with a program. This groups are called roles.

El concepto es fácil de aprender. Generalmente, en un proceso de negocios común usted se encarga de varias docenas de permisos. También puede tener desde 10 a 100 usuarios. Ya que los usuarios no son totalemente particulares, puede divirlos en grupos lógicos de acuerdo a cómo se llevan con el programa. Estos grupos de llaman roles.

The direct user management via permission assignment could be tiring and wrong because of users and permissions plurality.

La supervisión directa de usuarios a través asignación de permisos puede ser agotadora debido a los usuarios y la pluralidad de los permisos.


- You can group one, two or more permissions into a roles.
- A user can be assigned with one or a number of roles.
- A set of permissions in possession of a user is calculated as the concatenation of permissions from every role of the user.

- Puede agrupar uno, dos o más permisos en un rol.
- A un usuario se le puede asignar uno o varios roles.
- Un grupo de permisos que posea un usuario se calcular como la concadenación de permisos de cada rol del usuario.


A user has several flavors of role management:

Un usuaruio tiene varios tipos de manejo de roles:

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

Roles also have the following procedures:

Los roles también tienen el siguiente procedimiento:

```php
// Returns all users with the role
$role->getUsers();
```


## Creación del Rol de Administrador

Run the following command to create a user with supreme (at the moment of creation) rights:

Ejecute el siguiente comando para crear un usuario con derechos supremos (en el momento de la creación):


```php
php artisan make:admin nickname email@email.com secretpassword
```


## Añadiendo permisos personalizados


You can set up your own permissions in applications. 
Using them you can implement an access to specific functions.

Puede establecer sus propios permisos en las aplicaciones.
Haciendo uso de estos, puede implementar un acceso a funciones específicas.

Example of adding the custom permissions with the use of provider:

Ejemplo de añadición de permisos personalizados utilizando un provedor:

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
