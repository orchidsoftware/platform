# Ang Screen
----------

Ang Screen ay isang aplikasyong screen para sa pagpapakita ng datos. Hindi nito alam kung saan nagmumula ang datos, maaaring mula sa database, mga tsanel ng OData, API o kahit anong panlabas na pinagmulan. Ang screen ay may karaniwang functionality ng isang modernong tagagamit na interface. Mababago mo ang mukha ng screen, magdagdag at magtanggal ng mga utos.
    Ang pagtatayo ng mukha ay nakabase sa ibinigay na mga layout (mga layout) at lahat ng kailangan mong gawin ay alamin lamang kung aling datos ang ipapakita sa isang partikular na template.



## Bakit hindi CRUD?

Halos lahat ng mga sikat na add-in ay gumagamit ng konstruksyon ng CRUD para sa karaniwang mga modelo. Maganda itong solusyon, pero ang aplikasyon ay hindi maaaring maglalaman lamang ng mga pangunahing function. Kadalasan, magpapalawak at magdaragdag ka sa nalikhang lohika. Ang magandang halimbawa ay ang katotohanang ang istandard na mga operasyon para sa paglikha/pagbasa/pagbago/pagtanggal ay hindi sapat para sa kakayahang "Send to print." Ang ORCHID ay nagbibigay daan sa iyo na lumikha ng isang CRUD gamit ang "Mga Screen", pero hindi ito ang kanilang layunin.


### Pang-impormasyong mga bagay at screen

Pinapadali ng ORCHID ang pagbubuo ng mga aplikasyong pangnegosyo sa pamamagitan ng aktibong paggamit ng Laravel at mga screen.

Ang mga screens (o anyo) ay ginagamit sa ORCHID upang ilahad ang mga datos. Ang mga screen ay nakabase sa natutukoy na mga template. Upang iugnay ang datos sa screen, kailangan mo lang tukuyin ang mga nailahad na entidad o mga katanungan.


### Paglilikha

Upang makalikha ng bagong screen, kailangan mong paganahin ang sumusunod na utos:

```php
php artisan orchid:screen Users
```

Sa `app/Http/Screens` direktoryo, ang `Users` na file ay malilikha sa sumusunod na nilalaman:

```php
namespace App\Http\Screens;

use Illuminate\Http\Request;
use Orchid\Platform\Screen\Screen;

class Users extends Screen
{
    /**
     * Ipakita ang pangalan ng header
     *
     * @var string
     */
    public $name = 'Users Screen';

    /**
     * Ipakita ang deskripsyon ng header
     *
     * @var string
     */
    public $description = 'Users Screen';

    /**
     * Maghihingi ng datos
     *
     * @return array
     */
    public function query() : array
    {
        return [];
    }

    /**
     * Mga pipinduting utos
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [];
    }

    /**
     * Mga view
     *
     * @return array
     */
    public function layout() : array
    {
        return [];
    }
}

```

### Datos

Ang datos na ipapakita sa screen ay natutukoy sa `query` na pamamaraan, kung saan ang mga halimbawa o impormasyon ay dapat nilikha.
Ang paglipat ay naisakatuparan sa anyo ng isang hanay, ang mga key ay makikita sa mga layout, upang pamahalaan ang mga ito.

```php
    /**
     * Query data
     *
     * @return array
     */
    public function query() : array
    {
        return [
            'user'  => User::find(1),
            'users' => User::paginate(),
        ];
    }
```


### Ang Pagtatrato

Ang mga screen ay nagbibigay ng mga built-in na utos (Screen Command Bar), na nagbibigay daan sa mga tagagamit na gawin ang iba't ibang mga pamamaraan.
Para dito, ang `commandBar` na pamamaraan, kung saan ang kinakailangang pipinduting kontrol ay inilalarawan ay sumasagot. Halimbawa:

```php
/**
* Pipinduting mga utos
*
* @return array
*/
public function commandBar() : array
{
return [
    Link::name('Print')->method('print'),
];
}
```

Ang link ay sumasagot sa kung anong mangyayari sa pagpindot sa pipindutin, sa halimbawa sa itaas, kapag pinindot mo ang 'Print' na pipindutin,
ang screen na pamamaraang `print` ay tatawagin, lahat ng datos na nakita ng tagagamit sa screen saw on the screen ay makikita sa kahilingan.

```php
//sa pagpindot ng 'create'
Link::name('New function')->method('create');

//Sa pagpipindot, ireredirekta ka sa itinakdang address
Link::name('Link')->link('http://google.com/');

//Sa pagpindot, ipapakita nito ang modal na window (CreateUserModal),
//kung saan mapapagana mo ang "save"
Link::name('Modal windows')
->modal('CreateUserModal')
->title('New User')
->method('save'),
```


### Mga layout

Ang mga layout ay responsable sa mukha ng screen, iyon ay, kung paano at kung anong anyo ipapakita ang datos.
Para sa karagdagang impormasyon, tingnan ang [Mga Layout](/ph/docs/layouts.md/).

Bawat layout ay makakalakip ng iba pang layout,tinatawag itong nesting.
Halimbawa, ang screen ay hinati sa dalawang hanay, sa kaliwang margin para sa pagpupuna, sa kanan ay isang pagbabatayang talahanayan at isang grap.
Makakabuo ka ng sarili mong mga halimbawa ng mga paglalakip.


```php
/**
 * Mga View
 *
 * @return array
 */
public function layout() : array
{
    return [
        Layouts::columns([
            'Left column' => [
                PatientFirstRows::class,
            ],
            'Right column' => [
                PatientSecondRows::class,
            ],
        ]),
        Layouts::columns([
            'Left column' => [
                AppointmentListLayout::class
            ],
            'Right column' => [
                InvoiceListLayout::class
            ],
        ]),
        //Modals dialog
        Layouts::modals([
            'Appointments' => [
                PatientFirstRows::class,
            ],
        ]),
    ];
}
```

### Pagrerehistro sa mga ruta

Makakarehistro ka ng bawat screen gamit ang pamamaraang `screen` mula sa ruta
```php
Route::screen ('/ news', 'NewsList', 'platform.screens.news.list');
//or
$route->screen ('/ news', 'NewsList', 'platform.screens.news.list');
```



#### Malapit nang matapos ang dokumentasyon
