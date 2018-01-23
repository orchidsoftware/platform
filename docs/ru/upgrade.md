# Руководство по обновлению
----------


Мы стараемся задокументировать все изменения, которые могут вызывать проблемы. 
Но настоятельно рекомендуем не проводить изменения без сохранённой копии.


> **Примечание**. Выпуск 2.1 ещё не состялся, пожалуйста подождите.

# Обновление с 2.0 до 2.1

## Изменения 

### Объявление полей

С новым обновлением ORCHID вводит новую запись полей и форматирование таблиц.
Более подробне обсуждение можно посмотреть в issue #391

**Старый вид:**
```php
'body' => 'tag:tag|wysiwyg|name:body|max:255|required|rows:10',
```

**Новый вид:**
```php
Field::tag('wysiwyg')
    ->name('body')
    ->max(255)
    ->required()
    ->rows(10),
```

Устаревший вид будет поддерживаться некоторое время, но лучшим вариантом для долгосрочной поддержки
будет обернуть старый вариант так:

```php
'body' => Field::make('tag:tag|wysiwyg|name:body|max:255|required|rows:10'),
```

Стобцы таблиц, так же подверглись изменениям и имеют запись:

```php
TD::name('appointment_type')
->title('Type')

// Расширенный вариант
TD::name('appointment_time')
    ->title('Time')
    ->width('200px')
    ->setRender(function ($appointment){
    return $appointment->appointment_time->toDateString();
}),
```


### Поведения

Множественные поведения больше не имеют свойства по умолчанию:

```php
/**
 * HTTP data filters
 *
 * @var array
 */
public $filters = [
    SearchFilter::class,
    StatusFilter::class,
    CreatedFilter::class,
];
```

Для единообразие он был заменён на метод:

```php
/**
 * HTTP data filters
 *
 * @return array
 */
public function filters() : array
{
    return [
        SearchFilter::class,
        StatusFilter::class,
        CreatedFilter::class,
    ];
}
```




## Удалённые функции

### Поля
Были удалены мало практичные возможности которые ранее были объявлены устарешими:
- Поле `robot`
- Widget для Google Analytics

Более функциональная альтернатива полю `robot`:

```php
Field::tag('select')
    ->options([
        'index' => 'Index',
        'noindex' => 'No index',
    ])
    ->name('robot')
    ->title('Indexing')
    ->help('Allow search bots to index page'),
```

