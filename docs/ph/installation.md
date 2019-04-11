# Instalasyon
----------

Ang Gabay sa Pagsimulang ito ay tutulong sa iyong simulan ang paggamit ng ORCHID. Inilista namin ang mga pangunahing hakbang na kailangan mong gawin upang masimulan ang proyekto. Ang plataporma ay nakabase sa [Laravel Framework](http://laravel.com),
kaya bago ka magsimula, kailangan mong i-install ang [`Laravel`](http://laravel.com), at siguraduhin ring naaabot ng iyong kompyuter ang mga mahahalagang [kinakailangan](/ docs/requirements /).

## Lumikha ng proyekto

Ang plataporma at balangkas ay gumagamit ng Composer upang magbigay at pamahalaan ang mga dependency nito.
I-install ang balangkas sa pamamagitan ng pagpapatakbo ng `composer create-project` na utos sa iyong terminal:

```php
$composer create-project --prefer-dist laravel/laravel orchid
```

Nililikha nito ang bagong direktoryong `orchid`, naglo-load ng ilang mga dependency dito, at nililikha na rin pati mga pangunahing direktoryo at file na kakailanganin mo upang makapagsimula. Sa ibang salita, i-install nito ang bago mong balangkas na proyekto.

> May Composer ka ba? Madali lang i-install ang mga sumusunod na mga instruksyon sa [download na pahina](https://getcomposer.org/download/).

**Huwag kalimutan**
- Itakda ang mga karapatan "chmod -R o + w" sa mga direktoryong `storage` at ` bootstrap/cache`
- Baguhin ang `.env` na file


## Magdagdag ng pakete

Pumunta sa nalikhang direktoryo ng proyekto at paganahin ang utos:
```php
$composer require orchid/platform
```

> ** Tandaan: ** Kapag sa ibang paraan mo na-install ang Laravel, baka kailangan mong maglikha ng isang key
gamit ang `php artisan key: generate`

## Mga Setting sa Paglathala

Inilathala namin ang mga setting at auxiliary na mga file sa aming aplikasyon:
```php
php artisan vendor: publish --provider = "Orchid\Platform\Providers\FoundationServiceProvider"
php artisan vendor: publish --all
```


> ** Tandaan. ** Kailangan mo ring maglikha ng bagong database at i-update ang `.env` na file kasama ang mga kredensyal at idagdag ang URL ng iyong aplikasyon sa variable na `APP_URL`.


Iaaplay natin ang lahat ng ating mga paglipat upang buuin ang database:
```php
php artisan migrate
```

Ginawa nating magagamit ang mga karaniwang istilo, javascript na skrip at ibang mga file para sa pag-address gamit ang address bar:
```php
php artisan storage: link
php artisan orchid: link

```


## Modelo ng Tagagamit

Ang plataporma ay may handang hanay ng mga tagagamit na function, bilang halimbawa, access na mga karapatan
Kailang i-inherit ang basehang modelo sa `App\Users`:

```php
namespace App;

use Orchid\Platform\Models\User as BaseUser;

class User extends BaseUser
{

}

```

Upang makalikha ng isang tagagamit na may pinakamataas na karapatan sa kasalukuyang pagkakataon, kailangan mong paganahin ang utos sa pamamagitan ng pagpasa ng
username, email address at password:
```php
php artisan orchid: admin admin admin@admin.com password
```

## Ilunsad ang proyekto

Upang masimulan ang proyekto, magagamit mo ang built-in na server:
```php
php artisan serve
```

Buksan ang browser at pumunta sa `http: //localhost: 8000/dashboard`. Kapag ang lahat ay gumgagana, makakakita ka ng login na pahina sa control panel. Sa ilang saglit, kapag tapos ka na, patigilin ang server sa pamamagitan ng pagpindot ng `Ctrl + C` sa terminal na ginagamit.

> ** Tandaan: ** Kapag ang iyong runtime ay na-configure sa ibang domain (halimbawa, orchid.loc),
 ang admin na panel ay hindi magagamit, kailangan mong tukuyin ito sa konpigurasyong file na `config/platform.php`
 o sa `.env`. Ginawa nitong magagamit ang admin na panel sa ibang domain o subdomain, bilang halimbawa `platform.example.com`.
 
 
May problema sa instalasyon? Posibleng may isang taong may ganito nang problema https://github.com/orchidsoftware/platform/issues. Kung hindi, makakapagpadala ka ng mensahe o humingi ng [tulong](https://github.com/orchidsoftware/platform/issues).
