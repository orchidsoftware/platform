# Mga Field
----------

Ang mga field ay ginagamit sa paglikha ng isang template na output ng pagpupuna/pagbabago na porma

Lahat ng posibleng mga field ay inilalarawan sa `config/platform.php` sa seksyon ng mga field
Ang bawat field ay maaaring gamitin sa isang uri at kapag kailangan mong lumikha ng sarili mo, huwag mag-alinlangan.
Ang field ay nagsasangkot ng isang klase na may kasamang mandatoryong `create` na pamamaraan, na magbubuhat ng 'view' na ipapakita sa tagagamit
 
```php
//Mga field na pwedeng gumawa ng mga template
'fields' => [
    'textarea'     => Orchid\Screen\Fields\Types\TextAreaField::class,
    'input'        => Orchid\Screen\Fields\Types\InputField::class,
    'list'         => Orchid\Screen\Fields\Types\ListField::class,
    'tags'         => Orchid\Screen\Fields\Types\TagsField::class,
    'robot'        => Orchid\Screen\Fields\Types\RobotField::class,
    'relationship' => Orchid\Screen\Fields\Types\RelationshipField::class,
    'place'        => Orchid\Screen\Fields\Types\PlaceField::class,
    'picture'      => Orchid\Screen\Fields\Types\PictureField::class,
    'datetime'     => Orchid\Screen\Fields\Types\DateTimerField::class,
    'checkbox'     => Orchid\Screen\Fields\Types\CheckBoxField::class,
    'code'         => Orchid\Screen\Fields\Types\CodeField::class,
    'wysiwyg'      => Orchid\Screen\Fields\Types\TinyMCEField::class,
    'password'     => Orchid\Screen\Fields\Types\PasswordField::class,
    'markdown'     => Orchid\Screen\Fields\Types\SimpleMDEField::class,
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
