# Mga Field
----------

Ang mga field ay ginagamit sa paglikha ng isang template na output ng pagpupuna/pagbabago na porma

Lahat ng posibleng mga field ay inilalarawan sa `config/platform.php` sa seksyon ng mga field
Ang bawat field ay maaaring gamitin sa isang uri at kapag kailangan mong lumikha ng sarili mo, huwag mag-alinlangan.
Ang field ay nagsasangkot ng isang klase na may kasamang mandatoryong `create` na pamamaraan, na magbubuhat ng 'view' na ipapakita sa tagagamit
 
```php
//Mga field na pwedeng gumawa ng mga template
'fields' => [
    'textarea'     => Orchid\Platform\Fields\Types\TextAreaField::class,
    'input'        => Orchid\Platform\Fields\Types\InputField::class,
    'list'         => Orchid\Platform\Fields\Types\ListField::class,
    'tags'         => Orchid\Platform\Fields\Types\TagsField::class,
    'robot'        => Orchid\Platform\Fields\Types\RobotField::class,
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

Huwag mag-alinlangang idagdag ang iyong mga field, halimbawa, upang gumamit ng madaling editor para sa iyo, o kahit anong bahagi



#### Kasindali lang ito ng mga kondisyong pansulat para sa pagpapatunay

Gaya ng napansin mo sa pag-iisa-isa ng mga field sa uri, parang ang mga parametro ay nasuri na para sa pagpapatunay, kaya lang dito maaari kang magpasa ng kahit nong parametro sa iyong field:

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
 
 
 
### Lugar
 
Ang 'lugar' ma field ay nangangailangan ng key para sa Google map na itatakda sa `config/service`
services.google.maps.key
```php
//
'google' => [
    'maps' => [
        'key' => 'sekretong string'
    ],
],
```
