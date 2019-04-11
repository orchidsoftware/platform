# Paglalahad ng mga impormasyon tungkol sa PHP
----------

Ang hakbang-hakbang na gabay na ito ay magpapakita ng proseso sa paglikha ng isang pampatupad na form para sa pahina ng mga setting na
magpapakita ng impormasyon tungkol sa kapaligiran ng PHP.


## Paglilikha ng isang form

Maglikha ng isang bagong file na `PhpInfoForm.php` sa direktoryong `app/Http/Forms`,
Ang file ay maglalamn ng isang "Pangalan" na katangian na ipapakita bilang isang wipe at
pamamaraang "Display"

> ** Tandaan. ** Bilang karagdagan sa pamamaraang pang-display, pwede mong tiyakin ang isang pangyayari kapag ang pag-aalis at pagse-seyb ay pinipilit.

Ang magreresultang file ay magiging:

```php
<?php

namespace App\Http\Forms;

use Orchid\Platform\Forms\Form;

class PhpInfoForm extends Form
{
    /**
     * @var string
     */
    public $name = 'PHP info';

    /**
     * Display Settings App.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get()
    {
        ob_start();
        phpinfo(-1);
        $phpInfo = ob_get_clean();

        $phpInfo = preg_replace(
            [
                '#^.*<body>(.*)</body>.*$#ms',
                '#<h2>PHP License</h2>.*$#ms',
                '#<h1>Configuration</h1>#',
                "#\r?\n#",
                "#</(h1|h2|h3|tr)>#",
                '# +<#',
                "#[ \t]+#",
                '#&nbsp;#',
                '#  +#',
                '# class=".*?"#',
                '%&#039;%',
                '#<tr>(?:.*?)"src="(?:.*?)=(.*?)" alt="PHP Logo" /></a><h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
                '#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
                '#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
                "# +#",
                '#<tr>#',
                '#</tr>#',
            ],
            [
                '$1',
                '',
                '',
                '',
                '</$1>'."\n",
                '<',
                ' ',
                ' ',
                ' ',
                '',
                ' ',
                '<h2>PHP Configuration</h2>'."\n".'<tr><td>PHP Version</td><td>$2</td></tr>'."\n".'<tr><td>PHP Egg</td><td>$1</td></tr>',
                '<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
                '<tr><td>Zend Engine</td><td>$2</td></tr>'."\n".'<tr><td>Zend Egg</td><td>$1</td></tr>',
                ' ',
                '%S%',
                '%E%',
            ],
            $phpInfo
        );

        $sections = explode('<h2>', strip_tags($phpInfo, '<h2><th><td>'));
        unset($sections[0]);

        $phpInfo = [];
        foreach ($sections as $section) {
            $heading = substr($section, 0, strpos($section, '</h2>'));

            preg_match_all(
                '#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',
                $section,
                $parts,
                PREG_SET_ORDER
            );

            foreach ($parts as $row) {
                if (!isset($row[2])) {
                    continue;
                } elseif ((!isset($row[3]) || $row[2] == $row[3])) {
                    $value = $row[2];
                } else {
                    $value = array_slice($row, 2);
                }

                if (in_array($row[1], ['HTTP_COOKIE', 'Cookie', 'Set-Cookie', '_SERVER["HTTP_COOKIE"]']) || strpos(
                        $row[1],
                        '_COOKIE['
                    ) !== false || strpos($row[1], '_REQUEST[') !== false) {
                    continue;
                }

                $phpInfo[$heading][$row[1]] = $value;
            }
        }

        return view('phpInfo', [
            'info' => $phpInfo,
        ]);
    }
}

```

> ** Tandaan ** Huwag pansinin kung ano ang isinulat sa pamamaraang ito, hindi mahalaga para sa atin na intindihin ang mga ito (Kinopya ko ito mula sa https://stackoverflow.com)

Ipapakita natin ang mga impormasyon sa anyo ng isang talahanayan, para dito maglilikha tayo ng `phpInfo.blade.php` sa ` resources/views` na direktoryo:

```php
<div class="wrapper-md">

    @foreach($info as $name => $item)
        <table class="table">
            <caption class="font-bold text-black">{{$name}}</caption>
            <tbody>
            @foreach($item as $key => $value)

                <tr>
                    <td width="50%"><span class="text-muted">{{$key}}</span></td>

                    <td class="text-right text-dark" width="50%">
                        @if(!is_array($value))
                            {{$value}}
                        @else
                            {{implode(', ',$value)}}
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach

</div>

```

Dapat nang palitan kapag ang display ay walang napapalawak na kahit ano, ilo-load ito (nakalakip) sa loob ng isang form.

## Check in

Nalikha na natin ang lahat ng mga mahahalagang kagamitan para sa display ng ating mga impormasyon sa katangian. Mananatiling iulat lamang nito ang payak na form,
tungkol sa pagkakaroon ng isang bagong form. Upang gawin ito, lumikha ng isang bagong listener na `app/Listeners/SettingPhpInfoListener.php`, na maglilipat
sa kalilikha lang na form:

```php
<?php

namespace App\Listeners;


use App\Http\Forms\PhpInfoForm;

class SettingPhpInfoListener
{
    /**
     * Panghawakan ang pangyayari.
     *
     * @return string
     *
     * @internal param SettingsEvent $event
     */
    public function handle() : string
    {
        return PhpInfoForm::class;
    }
}

```

Mananatiling nakakonekta ito sa listener sa pangyayari ng ating aplikasyon, para dito, sa `app/Providers/EventServiceProvider.php`
ihahayag natin ang:

```php
namespace App\Providers;

use App\Listeners\SettingPhpInfoListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Orchid\Platform\Events\SettingsEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Ang pangyayaring listener na mga mapping para sa aplikasyon.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],

        SettingsEvent::class => [
            SettingPhpInfoListener::class
        ],
    ];

    /**
     * Irehistro ang kahit anong pangyayari para sa iyong aplikasyon.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

``` 

Ngayon, makakapunta na tayo sa pahina ng mga setting at tingnan ang bagong tab na may impormasyon tungkol sa PHP.
 
