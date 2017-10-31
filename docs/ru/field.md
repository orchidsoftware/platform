# Поля
----------
Поля используются для генерации вывода шаблона формы заполнения/редактирования

Все возможные поля определены в `config/platform.php` в разделе полей.
Каждое поле может использоваться в поведении, и если вам нужно создать своё собственное поле, не стесняйтесь.
Поле состоит из одного класса с обязательным методом `create`, который должен реализовать `представление` для отображения пользователю


```php
// Доступные поля для формирования шаблонов
'fields' => [
    'textarea' => Orchid\Platform\Fields\TextAreaField::class,
    'input'    => Orchid\Platform\Fields\InputField::class,
    'tags'     => Orchid\Platform\Fields\TagsField::class,
    'robot'    => Orchid\Platform\Fields\RobotField::class,
    'place'    => Orchid\Platform\Fields\PlaceField::class,
    'datetime' => Orchid\Platform\Fields\DateTimerField::class,
    'checkbox' => Orchid\Platform\Fields\CheckBoxField::class,
    'code'     => Orchid\Platform\Fields\CodeField::class,
    'wysiwyg'  => Orchid\Platform\Fields\SummernoteField::class,
],
```


Поля и поведения указываются отдельно, что позволяет использовать лишь ключ, 
например в записи мы хотим wysing редактор, а значением будет класс. 
Это позволяет менять редактор с summernote на tinymce или ckeditor почти в один клик.

Не стесняйтесь добавлять свои поля, например, для использования удобного редактора для вас или любых компонентов


#### Это так же просто, как условия записи для проверки

Пример отображения поля
```php
return [
    'name' => 'tag:input
            |type:text
            |name:name
            |max:255
            |required
            |title:Name Articles
            |help:Article title',
];
```

или
```php
return [
    'body' => [
        'tag'      => 'wysiwyg',
        'name'     => 'body',
        'max'      => 255,
        'required' => true,
        'rows'     => 10,
    ],
];
```
 
 
 
### Локация
 
Поле `локация` требует, чтобы ключ для карты Google указывался в `config/service`
services.google.maps.key
```php
//
'google' => [
    'maps' => [
        'key' => 'secret string'
    ],
],
```
