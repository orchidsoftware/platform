# Виджет
----------

Виджет — это экземпляр класса Widget или унаследованного от него. Это компонент, применяемый, в основном, с целью оформления. Виджеты обычно встраиваются в представления для формирования некоторой сложной, но в то же время самостоятельной части пользовательского интерфейса.


К примеру, виджет календаря может быть использован для рендеринга сложного интерфейса. Виджеты позволяют повторно использовать код пользовательского интерфейса.

## Создание
	
Чтобы создать новый виджет, необходимо выполнить:

```php
php artisan orchid:widget MySuperWidget
```

В папке `app/Orchid/Widgets` создаться класс шаблон виджета, как и у контроллера, у виджета может быть собственное представление.
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
	'NameForMySuperWidget' => App\Widgets\MySuperWidget::class,
	]
```
Если виджет будет работать через ajax, регистрировать его не нужно.

## Использование


При вызове виджета по умолчанию исполняется метод `"handler"`.
Для подключения виджета необходимо выполнить в коде используя синтаксис Blade:
```php
@widget('NameForMySuperWidget')
```
или добавить в метод fields в шаблоне страницы
```php
return [
	Relationship::make()
		->name('my_title')
		->required()
		->title('My title')
		->handler(MySuperWidget::class),
        ];
```

## Переменные

Если необходимо передать переменную из шаблона в виджет, тогда при вызове виджета необходимо использовать дополнительный параметр, который может быть переменной или массивом.
```php
@widget('NameForMySuperWidget', $arguments)
```
и обрабатывать его в методе `"handler"` класса виджета.
```php
public function handler($arguments = null){
  dump($arguments);
  return view('mysuperwidget',[
            'arguments'  => $arguments,
         ]);
}
```

## AJAX Widget

Виджеты могут быть использованы для загрузки и подгруздки информации в полях для связи.
Метод `handler` должен возвращать массив содержащий массивы с ключами `id` и `text`. На пример:

```php
[[ "id" => 1, "text" => "some text"]]
```

свойство `$query` будет принимать текстовые значение для поиска, а `$key` цифровое значение. Например:
если введено значение `12345`, то это значение попадет в  `$key`, если введено слово `test`, то это значение
попадет в `$query`


```php
namespace App\Http\Widgets;

use Orchid\Widget\Widget;

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
