# Behaviors
----------

Behavior is the main part of the ORCHID content management system, rather than generating a CRUD for each model
You can select any object in a separate type, and it's easy to manage it. Behaviors apply only to
models based on 'Post', since it is the basis for typical data.

You need to describe the fields you want to receive and in what form, and its CRUD is built itself.
You can also specify the validation, or modules (See the section of the form).

![Behaviors](https://orchid.software/img/scheme/behaviors.jpg)

## Creating and registering behaviors


You can create behaviors using the following commands:

```php
//Create behaviors for one record
php artisan make: singleBehavior

//Create behaviors for many records
php artisan make: manyBehavior
```

Own behavior must be registered in `config/platform.php` in the type section


```php
//
'single' => [
    //App\Core\Behaviors\Single\DemoPage::class,
],

//
'many' => [
    //App\Core\Behaviors\Many\DemoPost::class,
],
```

> To display the user's behavior, it is necessary to give it
or group (s) with the necessary rights using the graphical interface

The type looks like this:

```php
namespace DummyNamespace;

use Orchid\Platform\Behaviors\Many;

class DummyClass extends Many
{

    / **
     * @var string
     * /
    public $name = '';

    / **
     * @var string
     * /
    public $slug = '';

    / **
     * @var string
     * /
    public $icon = '';

    / **
     * Slug url/news/{name}.
     * @var string
     * /
    public $slugFields = '';

    / **
     * Rules Validation.
     * @return array
     * /
    public function rules ()
    {
        return [];
    }

    / **
     * @return array
     * /
    public function fields ()
    {
        return [];
    }

    / **
     * Grid View for post type.
     * /
    public function grid ()
    {
        return [];
    }

    / **
     * @return array
     * /
    public function modules ()
    {
        return [];
    }
}

```

You can extend the data type by all available methods,
 To add to it new functionality that matches your application

 
Modifying the Grid
 

The data that you want to display in the grid can be changed,
 passing an array with the name and function instead of the value of the key,
  where the transmitted parameter is the original data slice.

 ```php
 / **
  * Grid View for post type.
  * /
 public function grid ()
 {
     return [
         'name' => 'Name',
         'publish_at' => 'Date of publication',
         'created_at' => 'Date of creation',
         'full_name' => => [
             'name' => 'Full name',
             'action' => function ($post) {
                 return $post->getContent ('fist_name')
                  . ' '.
                  $post->getContent ('last_name');
             }
         ],
     ];
 }

```
