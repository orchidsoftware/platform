# Differentiation of access rights
----------
Role-based access control - the development of selective access control policy,
while permissions system subjects to objects are grouped with regard to their specific application,
forming a role.

Formation of roles is intended to define clear and understandable for users
access control rules. Role-based access control allows for flexible,
changing dynamically during operation of the rules of access control systems.

## User

The user has several options for managing roles

```php
// Check if the user has an extension
// Verification carried out both in himself and in his role
Auth::user()->hasAccess($string);

// Get all the user role
Auth::user()->getRoles();

// Check if the user has a role
Auth::user()->inRole($role)

// Add a user role
Auth::user()->addRole($role)
```

## Roles

Roles also have procedures for:

```php
// Returns all users with this role
$role->getUsers();

```


## Creating administrator

To create a user with the maximum (at a time of writing) rights
run the following command:


```php
php artisan make:admin nickname email@email.com secretpassword
```


## Adding your own permissions

An example of adding their own extensions using the provider

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
