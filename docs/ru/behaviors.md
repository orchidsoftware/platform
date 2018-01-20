# Поведения 
----------

Поведение является основной частью системы управления содержимым ORCHID, вместо того, чтобы генерировать CRUD для каждой модели
Вы можете выбрать любой объект в отдельном типе, и легко управлять им. Поведения применяются только к
моделям на основе 'Post', так как она является базовой для типичных данных.

Вам необходимо описать поля которые хотите получить и в каком виде, а её CRUD построиться сам.
Так же можно указать валидацию, или модули (См. Раздел формы).

![Behaviors](https://orchid.software/img/scheme/behaviors.jpg)

## Создание и регистрация поведений


Вы можете создать поведения с помощью команд:

```php
//Создать поведения для одной записи  
php artisan make:singleBehavior      

//Создать поведения для многих записей
php artisan make:manyBehavior
```

Собственное поведение должно быть зарегистрировано в `config/platform.php` в разделе типов


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

> Для отображения поведения у пользователя необходимо наделить его
или группу (роли) необходимыми правами с помощью графического интерфейса

Тип выглядит следующим образом:

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

Вы можете расширить тип данных всеми доступными методами,
 чтобы добавить к нему новую функциональность, которая соответствует вашему приложению

 
## Модификация сетки
 

Данные, которые вы хотите отобразить в сетке, можно изменить,
 передав массив с именем и функцией вместо значения ключа,
  где переданный параметр является исходным срезом данных.

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
