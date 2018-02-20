# Awtorisasyon
----------


## Madaliang Gabay sa Pagsimula

Sa naitatag na konpigurasyon ng ORCHID, mayroon nang naka-built-in
na pahina para sa pag-aawtorisa ng tagagamit, kung saan ito ay istandard
sa address na `/ dashboard/login`.

Sa yugto ng instalasyon, nakukuha mo ang modelo sa `app/User.php`, upang
makapagpalawak at sabayang ipaalam sa Laravel kung aling modelo sa pag-aawtorisa ang gagamitin
(Tingnan ang konpigurasyong file `config/auth.php`).



## Pagbabago

Ang awtorisasyon ay gumagamit ng karaniwang Laravel na input form, na nangangailangan lamang ng dalawang parametro
`E-mail` at` Password`. Sa totoong mga aplikasyon, baka kakailanganin mo ang kakayahang mabago,
 halimbawa, gamitin ang `ldap` o login sa pamamagitan ng mga social network. Upang gawin ito, kailangan mong lumikha ng
 sariling pahina kung saan mo ito pwedeng baguhin.
 
Una sa lahat, patayin ang ating built-in na pahina sa pag-aawtorisa, dahil binabago nito ang halaga ng `display`
sa konpigurasyong file:

```php
'auth' => [
    'display' => false,
],
```
 
 
Gamitin ang naka-built-in na Laravel na utos upang lumikha ng mga blanko ng lahat ng mga kinakailangang ruta at mga template
 gamit ang utos na:

```php
php artisan make: auth
```

Magdagdag tayo ng `auth` na middleware sa konpigurasyon ng plataporma ` config/platform.php`, para sa mga tamang pagredirekta.
Mangyaring tandaan na kailangan mong itakda ito bago ang `dashboard`
```php
    'middleware' => [
        'public' => ['web'],
        'private' => ['web', 'auth', 'dashboard'],
    ],
```
