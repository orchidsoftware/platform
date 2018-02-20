# Permissions
----------
Role-based access control - developing a policy of selective access control,
while the objects of permission systems are grouped according to their specific application, a role is formed.

Formation of roles is intended to define user-friendly access control rules.
Role-based access control allows flexible, dynamic changes during the operation of access control systems.

Resolution is the smallest unit of rights that a user can have.
You can check if the user has permission with the specified name.


## User

Typically, users are not assigned permissions in the ORCHID application (although there is such an option), but rather roles. The role associated with permitting, not with a single user.

This concept is very simple. As a rule, you manage several dozen permits in a typical business
process.
You can also have, say, 10 to 100 users.
 Although these users are not completely different from each other,
  You can divide them into logical groups according to what they do with the program.
   These groups are called roles.

If you needed to manage users directly by assigning them permissions,
 it would be tedious and erroneous,
because of the large number of users and permissions.


- You can group one, two or more permissions into roles.
- The user is assigned one or more roles.
- A set of permissions that the user owns,
 is calculated as the union of the permissions from each user role.


The user has several options for managing roles:

```php
//Check if the user has rights
//The check is performed both for the user and for his role
Auth: user()->hasAccess ($string);

//Get all user roles
Auth::user()->getRoles ();

//Check if the user has a role
Auth::user()->inRole ($role)

//Add a role to the user
Auth::user()->addRole ($role)
```

## Roles

Roles also have procedures for:

```php
//Returns all users with this role
$role->getUsers ();
```


## Create an administrator

To create a user with the maximum rights (at the time of creation) run the following command:


```php
php artisan make: admin nickname email@email.com secretpassword
```


## Adding your own permissions


You can define your own permissions in applications.
 Using them, you explicitly implement access to certain functions.

Example of adding your own permission using the provider:

```php
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Kernel\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    / **
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     * /
    protected $defer = false;

    / **
     * @param Dashboard $dashboard
     * /
    public function boot (Dashboard $dashboard)
    {
        $permission = $this->registerPermissions ();
        $dashboard->permission->registerPermissions ($permission);
    }

    protected function registerPermissions ()
    {
        return [
            'Modules' => [
                [
                    'slug' => 'Analytics',
                    'description' => 'Description',
                ],
            ],

        ];
    }
}
```
