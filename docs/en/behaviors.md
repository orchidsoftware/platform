#Behaviors 
----------

Behaviors are the main part of ORCHID, instead of generating a CRUD for each model
You can select any entity in a separate type and easily operate it


Own behaviors must be registered in `config/platform.php` in the types section


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


The type looks like this:

```php
namespace DummyNamespace;

use Orchid\Platform\Behaviors\Many;

class DummyClass extends Many
{

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $slug = '';

    /**
     * @var string
     */
    public $icon = '';

    /**
     * Slug url /news/{name}.
     * @var string
     */
    public $slugFields = '';

    /**
     * Rules Validation.
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [];
    }

    /**
     * Grid View for post type.
     */
    public function grid()
    {
        return [];
    }

    /**
     * @return array
     */
    public function modules()
    {
        return [];
    }
}

```

You can extend the data type with all the available methods to add a new functionality to it that corresponds to your application
 

 
#### Modification Grid
 
The data that you want to display in the grid can be modified by passing an array with a name and function instead of the key value, where the passed parameter is the original data slice.

 ```php
 /**
  * Grid View for post type.
  */
 public function grid()
 {
     return [
         'name'       => 'Name',
         'publish_at' => 'Date of publication',
         'created_at' => 'Date of creation',
         'full_name'  =>  => [
             'name' => 'Full name',
             'action' => function($post){
                 return  $post->getContent('fist_name') 
                  .' '.
                  $post->getContent('last_name');
             }
         ],
     ];
 }

```
 
 
You can create behaviors with commands:

```php
// Create behaviors for many records
Php artisan make:manyBehavior
  
// Create behaviors for one record
Php artisan make:singleBehavior 
```
