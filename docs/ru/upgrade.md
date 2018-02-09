# Руководство по обновлению
----------


> **Примечание**. Мы стараемся задокументировать все изменения, которые могут вызывать проблемы. 
Но настоятельно рекомендуем не проводить изменения без сохранённой копии.


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


Раздел полей в конфиругации теперь должен выглядеть так:

```php
'fields' => [
    'textarea'     => Orchid\Platform\Fields\Types\TextAreaField::class,
    'input'        => Orchid\Platform\Fields\Types\InputField::class,
    'list'         => Orchid\Platform\Fields\Types\ListField::class,
    'tags'         => Orchid\Platform\Fields\Types\TagsField::class,
    'select'       => Orchid\Platform\Fields\Types\SelectField::class,
    'relationship' => Orchid\Platform\Fields\Types\RelationshipField::class,
    'place'        => Orchid\Platform\Fields\Types\PlaceField::class,
    'picture'      => Orchid\Platform\Fields\Types\PictureField::class,
    'datetime'     => Orchid\Platform\Fields\Types\DateTimerField::class,
    'checkbox'     => Orchid\Platform\Fields\Types\CheckBoxField::class,
    'code'         => Orchid\Platform\Fields\Types\CodeField::class,
    'wysiwyg'      => Orchid\Platform\Fields\Types\TinyMCEField::class,
    'password'     => Orchid\Platform\Fields\Types\PasswordField::class,
    'markdown'     => Orchid\Platform\Fields\Types\SimpleMDEField::class,
],
```
