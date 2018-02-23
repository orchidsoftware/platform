# Gabay sa Pag-upgrade
----------


Sinusubukan naming idokumento ang lahat ng mga pagbabago na maaaring magdulot ng mga problema.
Pero lubos naming inirerekomenda na hindi ka gagawa ng mga pagbabago nang hindi naglalaan ng isang kopya.


> ** Tandaan **. Ang isyung 2.1 ay hindi pa natapos, mangyaring maghintay.

# Pag-upgrade mula 2.0 papuntang 2.1

## Mga Pagbabago

### Pagdedeklara ng mga field

Sa bagong update, ang ORCHID ay nagpapasok ng bagong isinusumiteng field at pagpopormat ng talahanayan.
Ang karagdagang mga detalye ay makikita sa isyu bilang 391

** Lumang mukha: **
```php
'body' => 'tag: tag | wysiwyg | name: body | max: 255 | required | rows: 10',
```

**Bagong uri:**
```php
Field::tag ('wysiwyg')
    ->name ('body')
    ->max (255)
    ->required ()
    ->rows (10),
```

Ang hindi na ginagamit na view ay papanatilihin sa isang sandali, pero ang pinakamabuting pagpipilian para sa pangmatagalang suporta
ay magra-wrap sa lumang bersyon katulad nito:

```php
'body' => Field::make ('tag: tag | wysiwyg | name: body | max: 255 | required | rows: 10'),
```

Ang mga hanay ng mga talahanayan ay nagkaroon din ng mga pagbabago at may datos na:

```php
TD::name ('appointment_type')
->title ('Type')

//Makabagong Pagpipilian
TD::name ('appointment_time')
    ->title ('Time')
    ->width ('200px')
    ->setRender (function ($appointment) {
    return $appointment->appointment_time->toDateString ();
}),
```


### Mga paggalaw

Ang maraming mga paggalaw ay wala nang mga default na katangian:

```php
/ **
 * HTTP na mga data filter
 *
 * @var array
 * /
public $filters = [
    SearchFilter::class,
    StatusFilter::class,
    CreatedFilter::class,
];
```

Para sa pagkakatugma, pinalitan ito ng sumusunod na pamamaraan:

```php
/ **
 * HTTP data filters
 *
 * @return array
 * /
public function filters (): array
{
    return [
        SearchFilter::class,
        StatusFilter::class,
        CreatedFilter::class,
    ];
}
```




## Mga Kalapit na Function

### Mga Field
Tinanggal namin ang ilang mga praktikal na posibilidad na idineklara nang hindi ginagamit:
- Ang field na `robot`
- Ang Widget para sa Google Analytics

Ang isang mas functional na alternatibo sa `robot` na field ay ang sumusunod:

```php
Field::tag ('select')
    ->options ([
        'index' => 'Index',
        'noindex' => 'No index',
    ])
    ->name ('robot')
    ->title ('Indexing')
    ->help ('Allow search bots to index page'),
```
