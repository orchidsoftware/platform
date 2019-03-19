# Comportamientos 
----------

Los comportamientos son la parte principal del sistema de supervisión de contenidos de ORCHID. En lugar de generar CRUD para cada modelo, pude seleccionar cualquier objeto bajo tipos separados y administrarlos fácilmente.
Los comportamientos son aplicables sólo para 'Postear' modelos basados, ya que es modelo base para información común.

Usted debería describir los campos que desea tener y sus estados, mientras que su CRUD será ensamblado automáticamente.
También puede especificar una validación o módulos. (Consulte la sección Forms).

![Behaviors](https://orchid.software/img/scheme/behaviors.jpg)

## Creando y registrando comportamientos
        
Siga el siguiente procedimiento para crear comportamientos:


```php
//Create behaviors for a single entry
php artisan make:singleBehavior

//Create behaviors for many entries 
php artisan make:manyBehavior
```

El comportamiento privado debe ser registrado en `config/platform.php` en la sección de tipos:


```php
//
'single' => [
    //App\Behaviors\Single\DemoPage::class,
],

//
'many' => [
    //App\Behaviors\Many\DemoPost::class,
],
```

> Para mostrar el comportamiendo del usuario, debe otorgar derechos imprescindibles al usuario o grupo (roles) utilizando la interfaz visual.

El tipo es el siguiente:

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

Puede extender el tipo de información de cualquier manera posible para añadir una nueva característica que corresponda a su aplicación.


## Modificiación de red


Puede cambiar la información que desea mostrar en red al pasar el arreglo con el nombre y la función en lugar del valor clave, donde el índice pasado es un segmento de información inicial.

 ```php
 /**
  * Grid View for post type.
  */
 public function grid()
 {
     return [
         TD::name('name')->title('Name'),
         TD::name('publish_at')->title('Date of publication'),
         TD::name('created_at')->title('Date of creation'),
         TD::name('full_name')->title('Full name')
         ->render(function($post){
             return  "{$post->getContent('fist_name')} {$post->getContent('last_name')}";
         })
     ];
 }

```
