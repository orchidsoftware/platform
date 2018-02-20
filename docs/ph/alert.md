# Mga Paalala
----------

Ang mga paalala ay isang madaling paraan upang ipaalam sa tagagamit ang estado ng iyong aplikasyon. Halimbawa, maipapalam nila sa tagagamit ang tungkol sa pagtatapos ng isang mahabang proseso o pagdating ng isang bagong mensahe. Sa seksyong ito, ipapakita namin kung paano sila pagaganahin sa iyong aplikasyon.

## Isahang-beses na mga mensahe:

Ang Flash-notification ay isang isahang-beses na mensahe na matatanggal sa susunod na access.
Ang mga paalala ay ginawa upang ipaalam ang tungkol sa direktang nangyaring pangyayari, halimbawa, isang mensahe tungkol sa pag-seyb ng datos.

Ang ORCHID ay may madaling pagtawag at nagpapakita ng mga paalala sa isahang-beses na flash data.


```php
public function store ()
{
    Alert::message ('Maligayang Pagdating!');
    return Redirect::home ();
}
```

Maaari mo ring gawing:

```php
Alert::info ('Mensahe')
Alert::success ('Mensahe')
Alert::error ('Mensahe')
Alert::warning ('Mensahe')
```

o gumamit ng isang mas maikling tala:

```php
alert ('Message');
```


Kapag ginamit, maraming mga key ang mai-install sa sesyon:
- 'flash_notification.message' - Pinapakitang Imahe
- 'flash_notification.level' - Isang string na kumakatawan sa uri ng paalala

Upang ipakita sa kinakailangang lokasyon:
```html
<div class = "container">
    @include ('dashboard::partials.alert')
    <p> Maligayang pagdating sa aking websayt ... </ p>
</ div>
```

## Mga paalala sa administrasyong panel

Ang paalala sa administrasyong panel ay naiiba sa mga flash na mensahe, dito di sila natatanggal pagkatapos ng pag-view at
maaaring idagdag sa kahit sinong tagagamit kahit na wala sila sa network. Isa itong ibang mabuting paraan sa pagpapaalam,
halimbawa, para sa "task manager" na aplikasyon, pinapaalam ang isang empleyado tungkol sa bagong gawain.

Upang makalikha ng paalala, kailangan mo ng:
```php
$user = User::find (1);

$user->notify (new\Orchid\Platform\Notifications\DashboardNotification ([
    'title' => 'Kumusta na Salita',
    'message' => 'Bagong lathala!',
    'action' => 'https://google.com',
    'type' => 'mali',
]));
```

Sinusuportahang uri:

- info (Naka-default)
- success
- warning
- error
