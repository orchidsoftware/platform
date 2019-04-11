#Mga Reaktibong Link
----------

Ang mga aktibong link ay isang auxiliary na pakete na pinapadaling makilala
ang kasalukuyang address (Url) o ruta (Route), napakahalaga para sa pagdagdag ng isang klase
`active` (bilang halimbawa, iyong ginagamit sa Bootstrap), at
Iba't-ibang mga aksyon lamang kapag ang isang ruta ay aktibo.
Isinasali rin nito ang isang katulong upang makuha ang kasalukuyang tagakontrol at aksyon na mga pangalan.

## Mga Katulong ng mga Function

Ang mga aktibong mga link na may kasamang maraming mga auxiliary na function na pinapadali ang paggamit nang walang facade.
```php
active ()
is_active ()
```

## Paggamit ng `active ()`

Magpasa ka ng hanay ng mga ruta o daan na gusto mong makita, ito ang kasalukuyang pahina, at kapag may tumugma sa function na ito, ibinabalik nito ang string na `active`, para sa Bootstrap. Bilang karagdagan, makakapasa ka ng karaniwang pabalik na string bilang pangalawang argumento.

```php
//Ibinabalik ang "active" kapag ang kasalukuyang ruta ay tumugma sa kahit anong daan o pangalan ng daan.
active ('login', 'users/*', 'posts. *', 'pages.contact');

//Ibinabalik ang "active class" kapag ang kasalukuyang ruta ay "login" o "log off".
active (['login', 'logout'], 'active-class');
```

Sa unang halimbawa, ang function ay nagbabalik ng string na `active`, kung ang kasalukuyang string ay ` login`, nagsisimula sa `users /` o kapag ang pangalan ng kasalukuyang ruta ay `posts.create`.

Tandaan na may maraming mga uri ng mga argumento: pwede mong gamitin ang isang path string, pwede mong gamitin ang isang string na may wildcard (gamit ang `* '), at pwede mo ring gamitin ang mga pinangalanang mga ruta.

Magagamit mo ang function na ito sa iyong mga link upang bigyan sila ng mga aktibong estado.

```php
<a href="{{ route('posts.index') }}" class="{{ active('posts.index') }}">
    Lahat ng mga lathala
</a>
```

Maaari mo ring itakda ang mga daan o mga ruta na kailangan suriin.
```php
active (['pages/*', 'not: pages/contact'])

active (['pages. *', 'not: pages.contact'])
```

## Paggamit ng `is_active ()`

Gumagana ito katulad ng `active ()`, mapapasa mo ito bilang mga daan at ruta, pero ibinabalik nito ang isang Boolean na halaga kapag ang kasalukuyang pahina ay tumugma.

```php
@if (is_active ('posts/*'))
    Tumitingin ka sa isang blog na lathala!
@endif
```

## Karagdagang mga katulong

Upang makakuha ng isang tagakontrol at ang aksyon, dalawang karagdagang mga function ay inilaan kapag ang iyong pagruruta ay pinroseso ng tagakontrol para sa hiling.
Ang mga function na ito ay nagbabalik ng tagakontrol/aksyon na pangalang string nang walang pamamaraan sa paghiling.
Ang sumusunod ay isang halimbawa ng isang kahilingan na naredirekta sa `FooController @ getBar ':
```php
$controller = controller_name (); //foo

$action = action_name (); //bar
```
