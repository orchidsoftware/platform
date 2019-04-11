# Mga Field
----------

Ang mga field ay ginagamit sa paglikha ng isang template na output ng pagpupuna/pagbabago na porma

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
