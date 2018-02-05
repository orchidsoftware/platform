# Displaying information about PHP
----------

This step-by-step guide demonstrates the process of creating an implementation form for the settings page that
will display information about the PHP environment.


## Creating a form

Create a new file called `PhpInfoForm.php` in the directory` app/Http/Forms`,
The file will consist of a single "Name" property that will be displayed as a wipe and
method "Display"

> ** Note. ** In addition to the display method, you can specify an event when deleting (deleting) and saving (persist)

The resulting file will be:

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

> ** Note ** Do not pay attention to what is written in this method, it is not important for us to understand (I copied it from https://stackoverflow.com)

We will display the information in the form of a table, for this we create `phpInfo.blade.php` in the` resources/views` directory:

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

It is worth replacing that the display does not expand anything, it will be loaded (included) already inside the existing form.

## Check in

We have created all the necessary resources for our feature information display. It remains only to report the basic form,
about the existence of a new. To do this, create a new listener `app / Listeners / SettingPhpInfoListener.php`, which will transfer
the newly created form:

```php
<?php

namespace App\Listeners;


use App\Http\Forms\PhpInfoForm;

class SettingPhpInfoListener
{
    /**
     * Handle the event.
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

It remains to connect the listener to the event of our application, for this, in `app / Providers / EventServiceProvider.php`
we indicate:

```php
namespace App\Providers;

use App\Listeners\SettingPhpInfoListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Orchid\Platform\Events\SettingsEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
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
     * Register any events for your application.
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

Now we can go to the settings page and see a new tab with information about PHP.
 
