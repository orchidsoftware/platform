# Виджет
----------

Виджет — это экземпляр класса Widget или унаследованного от него. Это компонент, применяемый, в основном, с целью оформления. Виджеты обычно встраиваются в представления для формирования некоторой сложной, но в то же время самостоятельной части пользовательского интерфейса.


К примеру, виджет календаря может быть использован для рендеринга сложного интерфейса. Виджеты позволяют повторно использовать код пользовательского интерфейса.

## Создание
	
Чтобы создать новый виджет, необходимо выполнить:

```php
php artisan make:widget MySuperWidget
```

В папке `app/Http/Widgets` создаться класс шаблон виджета, как и у контроллера, у виджета может быть собственное представление.
Рекомендуется располагать файлы виджета в поддиректории views.

```php
namespace App\Http\Widgets;

use Orchid\Widget\Service\Widget;

class MySuperWidget extends Widget {

    /**
     * Class constructor.
     */
    public function __construct(){

    }

    /**
     * @return mixed
     */
     public function handler(){
         return view('',[
         ]);
     }

}
```


Для регистрации Вашего нового виджета необходимо занести его в `config/widget.php`:

```php
'widgets' => [
    'NameForMySuperWidget' => App\Widgets\MySuperWidget::class
 ],
```
	


## Использование


При вызове виджета по умолчанию исполняется метод `"handler"`.
Для подключения виджета необходимо выполнить в коде используя синтаксис Blade:
```php
@widget('NameForMySuperWidget')
```




## AJAX Widget

Виджеты могут быть использованы для загрузки и подгруздки информации в полях для связи.

Тогда в свойство `$query` будет принимать значение для поиска, а `$key` выбранное значение.


```php
namespace App\Http\Widgets;

use Orchid\Platform\Widget\Widget;

class AjaxWidget extends Widget
{

    /**
     * @var null
     */
    public $query = null;

    /**
     * @var null
     */
    public $key = null;

    /**
     * @return array
     */
    public function handler()
    {
        $data = [
            [
                'id'   => 1,
                'text' => 'Запись 1',
            ],
            [
                'id'   => 2,
                'text' => 'Запись 2',
            ],
            [
                'id'   => 3,
                'text' => 'Запись 3',
            ],
        ];


        if(!is_null($this->key)) {
            foreach ($data as $key => $result) {

                if ($result['id'] === intval($this->key)) {
                    return $data[$key];
                }
            }
        }

        return $data;

    }

}

```
