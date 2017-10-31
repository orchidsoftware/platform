# Fields
----------

Fields are used to generate a template output of the fill / edit form

All possible fields are defined in `config/platform.php` in the fields section
Each field can be used in a type and if you need to create your own do not hesitate.
The field consists of one class with the obligatory `create` method, which must raise the 'view' to display to the user
 
```php
// Available fields to form templates
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

Do not hesitate to add your fields, for example, to use a convenient editor for you, or any components



#### It's as easy as writing conditions for validation

As you probably noticed the enumerations of fields in the type, it seems that the parameters have been cross-checked for validation, only here you can pass any parameters to your field:

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

or
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
 
 
 
### Place
 
The 'place' field requires the key for Google map to be specified in `config/service`
services.google.maps.key
```php
//
'google' => [
    'maps' => [
        'key' => 'secret string'
    ],
],
```
