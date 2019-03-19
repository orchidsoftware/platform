# Access rights
----------
Role-based access control is the development of sample access control policy. A role forms as the objects of authorization frameworks group depending on their specific application.

The formation of roles is aimed at the determination of user-understandable access control rules.  Role-based access control is allowed to vary dynamically and flexibly during the work of access control system.

Permission is the least unit of right that user can have. You can check if a user has a permission with specified name.


## User

In the ORCHID application users are usually given roles, not permissions (although, such possibility exists). The role related to a set of permissions rather than individual user. 

The concept is easy-to-learn. Usually, in a common business process you manage several dozens of permissions. Also, you can have from 10 to 100 users. While the users are not fully particular, you can divide them into logical groups according to how they deal with a program. This groups are called roles.

The direct user management via permission assignment could be tiring and wrong because of users and permissions plurality.


- You can group one, two or more permissions into a roles.
- A user can be assigned with one or a number of roles.
- A set of permissions in possession of a user is calculated as the concatenation of permissions from every role of the user.


A user has several flavors of role management:

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

## Roles

Roles also have the following procedures:

```php
// Returns all users with the role
$role->getUsers();
```


## Creation of administrator role

Run the following command to create a user with supreme (at the moment of creation) rights:


```php
php artisan orchid:admin nickname email@email.com secretpassword
```


## Adding custom permissions


You can set up your own permissions in applications. 
Using them you can implement an access to specific functions.

Example of adding the custom permissions with the use of provider:

```php
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $permissions = ItemPermission::setGroup('modules')
            ->addPermission('analytics', 'Access to data analytics')
            ->addPermission('monitor', 'Access to the system monitor');

        $dashboard->registerPermissions($permissions);
    }
}
```
