# Сущности системы управления содержимым
----------

Сущность является основной частью системы управления содержимым ORCHID, вместо того, чтобы генерировать CRUD для каждой модели
можно выбрать любой объект в отдельном типе, и легко управлять им. Сущность применяются только к
моделям на основе 'Post', так как она является базовой для типичных данных.

Вам необходимо описать поля которые хотите получить и в каком виде, а её CRUD построиться сам.
Так же можно указать валидацию, или модули (См. Раздел формы).

![Entities](https://orchid.software/img/scheme/entities.jpg)

## Создание сущности

Вы можете создать сущность с помощью команд:

```php
//Создать сущность для одной записи  
php artisan orchid:entity-single   

//Создать сущность для многих записей
php artisan orchid:entity-many
```

> Для отображения сущности пользователю, необходимо наделить его
или группу (роли) необходимыми правами с помощью графического интерфейса.

Тип выглядит следующим образом:

```php
namespace DummyNamespace;

use Orchid\Press\Entities\Many;

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
    public function options()
    {
        return [];
    }
}

```

Вы можете расширить тип данных всеми доступными методами,
 чтобы добавить к нему новую функциональность, которая соответствует вашему приложению.

 
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
         TD::set('name','Name'),
         TD::set('publish_at','Date of publication'),
         TD::set('created_at','Date of creation'),
         TD::name('full_name','Full name')->render(function($post){
             return  "{$post->getContent('fist_name')} {$post->getContent('last_name')}";
         })
     ];
 }

```
