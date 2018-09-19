# Using the screens
----------

This document is a step-by-step tutorial on how to develop the profile using `Screens`. Examples are picked up to help the newcomer to handle all the problems from start to end.

## Installation

At the beginning lets [install](/en/docs/installation) the Laravel ORCHID package

## Migrations

Let's perform the changes in ou database scheme to make it contain `Surname`, `Name` and authorization logging.

To do so perform the following:
```php
php artisan orchid:migration create_table_users_history
```

This command will create a new file in the `database/migrations` folder, and we will then make it look like:

```php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('platform')->nullable();
            $table->string('platform_version')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->ipAddress('address');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_history');
    }
}
```


Also let's create the second migration file that is related directly to our user:

```php
php artisan orchid:migration create_fields_for_users
```

With content:

```php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsForUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('city_id');
            $table->dropColumn('avatar');
        });
    }
}
```


Apply all the created migrations with the following command:

```php
php artisan migrate
```


## Data models


Right after we created and applied all the required migrations we need to create/change our models.
To do so we create a new model using with the following:

```php 
php artisan orchid:model History
```

In thw `app` directory a file called `History.php` will be created let's put the following code into it:

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\FilterTrait;
use Orchid\Platform\Traits\MultiLanguage;

class History extends Model
{
    use MultiLanguage, FilterTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = "auth_history";

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'platform',
        'platform_version',
        'browser',
        'browser_version',
        'address',
        'created_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'date'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param        $builder
     * @param string $columns
     * @return mixed
     */
    public function scopeGetStatisticsColumns($builder,string $columns){
        return $builder->selectRaw("$columns as title,count('browser') as `values`")
            ->groupBy($columns)
            ->get()->map(function ($item) {
                $item->values = [$item->values];
                return $item;
            })->toArray();
    }

}
```

in this model we defined the table, autocompleted fields, one-to-many connection and the method for acquiring the statistics for the column.

We will also need to change the User model:

```php
namespace App;

use Orchid\Platform\Models\User as BaseUser;

class User extends BaseUser
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login',
        'avatar',
        'permissions',
        'first_name',
        'last_name',
        'city_id',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history(){
       return $this->hasMany(History::class);
    }

}
```

## Authorization logging

To acquire the information about browser and used operational system we will use the `Agent` package, to install it do the following:

```php
composer require jenssegers/agent
```

To log authorization we create the listener `app/Listeners/UserEventSubscriber.php`:

```php
namespace App\Listeners;

use App\History;
use Jenssegers\Agent\Agent;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {

        $agent = new Agent();

        $browser = $agent->browser();
        $browser_version = $agent->version($browser, 'unknown');

        $platform = $agent->platform();
        $platform_version = $agent->version($platform, 'unknown');

        $history = new History([
            'platform'         => $platform,
            'platform_version' => $platform_version,
            'browser'          => $browser,
            'browser_version'  => $browser_version,
            'address'          => request()->getClientIp(),
        ]);
        $event->user->history()->save($history);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );
    }

}
```

And register it in `app/Providers/EventServiceProvider.php`:

```php
namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\UserEventSubscriber',
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


Now during every successfull authorization all the required information will be written to database, so we will be able to use it in future.


## Screen creation

ORCHID in standard complection does not include the user profile, so we will create it by ourselves using the `Screen`, to do so we perform the following:

```php
php artisan orchid:screen ProfileScreen
```

Artisan will create a new file in `app/Http/Controllers/Screens` directiory, and if you are a skillful user it's recomended to change this folder name to `app/Http/Screens`,

Let's add our new screen to the routing file `routes/web.php`:

```php
Route::screen('/dashboard/profile', 'Screens\ProfileScreen','platform.screens.profile');
```


## Registration of the new screen

To view our screen in the elements menu we need to add `View::composer` registrations to `app/Providers/AppServiceProvider.php`

Let's create the registration class `app/Http/Composers/MenuComposer.php`:

```php
namespace App\Http\Composer;

use Orchid\Platform\Dashboard;

class MenuComposer
{
    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     *
     */
    public function compose()
    {
        $this->dashboard->menu->add('Main', [
            'slug'   => 'profile',
            'icon'   => 'icon-user',
            'route'  => route('platform.screens.profile'),
            'label'  => 'Profile',
            'childs' => false,
            'main'   => true,
            'sort'   => 6000,
        ]);
    }
}
```

And register it into our service provider `app/Providers/AppServiceProvider.php`:
```php

namespace App\Providers;

use App\Http\Composer\MenuComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('platform::layouts.dashboard', MenuComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
```


Now, as our screen is displayed in menu, lret's proceed to filling it with content.

## Creation of AJAX data vidget

It might be noticed that we added the new `city_id` row to user without creating city model.
The standard laravel configuration file will be good enouhg for us.

Let's create the new file `config/city.php` and fill it with some cities of Russia:

```php
return [

    'list' => [
        [
            'id'   => 0,
            'text' => 'Moscow',
        ],
        [
            'id'   => 1,
            'text' => 'St. Petersburg',
        ],
        [
            'id'   => 2,
            'text' => 'Novosibirsk',
        ],
        [
            'id'   => 3,
            'text' => 'Ekaterinburg',
        ],
        [
            'id'   => 4,
            'text' => 'Nizhny Novgorod'
        ],
    ]
];
```

Let's create the widget to further be able to pass them on demand:

```php
php artisan orchid:widget CityWidget
```

A new file will be created in `app/Http/Widgets/CityWidget.php` and we don't need to register it like the template widgets.

We change it to always return the array of parameters:

```php
namespace App\Http\Widgets;

use Orchid\Widget\Widget;

class CityWidget extends Widget {

    /**
     * @var null
     */
    public $query = null;

    /**
     * @var null
     */
    public $key = null;

    /**
     * @return mixed
     */
    public function handler(){
        $data = config('city.list');

        if(!is_null($this->query) || !is_null($this->key)){
            return collect($data)->filter(function ($item) {

                if($item['id'] == $this->key){
                    return true;
                }

                return false !== stristr($item['text'], $this->query);
            })->toArray();
        }

        return $data;
    }

}
```

We've used the collections to be able to search by `id` and our city name.

it's not necessary to use the configuration parameters as storage, it may also be the cities model or even API.


## Base profile template creation

To be able to change the profile data it's nesessary to generate a form with input fields, let's create a new string template:

```php
php artisan orchid:row ProfileLayout
```

Add the fields we want to change for user in the `app/Layouts/ProfileLayout.php` file:


```php
namespace App\Layouts;

use App\Http\Widgets\CityWidget;
use Orchid\Screen\Field;
use Orchid\Platform\Layouts\Rows;

class ProfileLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Press\TypeException
     */
    public function fields(): array
    {
        return [

            Field::tag('picture')
                ->name('profile.avatar')
                ->title('Profile avatar')
                ->width(200)
                ->height(200),

            Field::tag('input')
                ->name('profile.name')
                ->required()
                ->title('Profile name'),

            Field::tag('input')
                ->name('profile.email')
                ->required()
                ->readonly()
                ->disable()
                ->title('E-mail'),

            Field::tag('input')
                ->name('profile.first_name')
                ->required()
                ->title('First name'),

            Field::tag('input')
                ->name('profile.last_name')
                ->required()
                ->title('Last name'),

            Field::tag('relationship')
                ->name('profile.city_id')
                ->required()
                ->title('City')
                ->handler(CityWidget::class),

        ];
    }
}
```

Now we need to specify that we will use it at our profile screen:

```php
namespace App\Http\Controllers\Screens;

use App\Layouts\ProfileLayout;
use Orchid\Platform\Screen\Screen;

class ProfileScreen extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'Profile';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Full user control in a single place';

    /**
     * Query data
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            ProfileLayout::class,
        ];
    }

}
```

The source of all our data is the `query` method, that's why we must pass the general data array. You could notice that 
in the template implementation we used the names `profile.`, that means the data will be further required from `profile` key.


```php
    use Illuminate\Support\Facades\Auth;
    
    /**
     * Query data
     *
     * @return array
     */
    public function query(): array
    {
        $profile = Auth::user();

        return compact('profile');
    }

```

Great, now as we may see all the form fields, lets add a button that will save everything when pressed.

To do so let's add the following to `commandBar` method:

```php
    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name('Update password')
                ->method('update')
        ];
    }

```

This will add the button to our screen that will trigger the `update` method on our screen.

Let's add this method:

```php

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        Auth::user()->fill($request->get('profile'))->save();

        Alert::info('Password has been updated successfully');
        return redirect()->back();
    }
```

Great, now we may not only display the required information but also change it.


## Creation of password change window

Our profile screen will not be complete without an ability to change the password, so let's add it!

To do so we create a new template:

```php
php artisan orchid:row ProfilePasswordLayout
```

It will only contain the fields `password` and `repeat the password`:

```php
namespace App\Layouts;

use Orchid\Screen\Field;
use Orchid\Platform\Layouts\Rows;

class ProfilePasswordLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Press\TypeException
     */
    public function fields(): array
    {
        return [
            Field::tag('password')
                ->name('profile.password')
                ->required()
                ->title('Enter password'),

            Field::tag('password')
                ->name('profile.password_confirmation')
                ->required()
                ->title('Confirm password')
                ->hr(false),

        ];
    }
}
```


And we will register it into a modal window in our screen:

```php
    /**
     * Views
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            ProfileLayout::class,
            Layouts::modals([
                'password' => [
                    ProfilePasswordLayout::class
                ],
            ])
        ];
    }
```

We have defined the group of modal windows that will have only one template.

Add the button:

```php

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name('Edit password')
                ->modal('password')
                ->title('Change password')
                ->method('changePassword'),
            Link::name('Update password')
                ->method('update')
        ];
    }
```

Now after pressing the button `Change password` the modal window with our template will be displayed.
As we can see, the method `method` stands for pressing the button.


```php
    /**
     * @param ChangePassword $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(ChangePassword $request)
    {
        Auth::user()->password = Hash::make($request->input('profile.password'));
        Auth::user()->save();

        Alert::info('Your password has been successfully changed');
        return redirect()->back();
    }
```

Great, our profile screen is almost ready.



## Creation of history layout

Let's add a table that will contain data about devices that were used to authorize, to do it we create a table layout:

```php
php artisan orchid:table HistoryLayout
```

```php
namespace App\Layouts;

use Orchid\Platform\Layouts\Table;
use Orchid\Platform\Platform\Fields\TD;

class HistoryLayout extends Table
{

    /**
     * @var string
     */
    public $data = 'history';

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            TD::name('created_at')
                ->title('Created at')
                ->width('150px')
                ->setRender(function ($item){
                return $item->created_at->toDateString();
            }),

            TD::name('address')
                ->width('150px')
                ->title('IP Address'),


            TD::name('platform')
                ->width('200px')
                ->title('Platform')
                ->setRender(function ($item){
                $platform_version = $item->platform_version;
                if(!$platform_version || $platform_version === 'unknown'){
                    $platform_version = "";
                }

                return "{$item->platform} {$platform_version}";
            }),

            TD::name('browser')
                ->title('Browser')
                ->setRender(function ($item){
                return "{$item->browser} {$item->browser_version}";
            }),
        ];
    }
}
```


It's necessary to register the layout for the screen and pass on our data:

```php
    /**
     * Query data
     *
     * @return array
     */
    public function query(): array
    {
        $profile = Auth::user();
        $history = History::where('user_id', $profile->id)->paginate();
        
        return compact('profile', 'history');
    }
```

```php
    /**
     * Views
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            ProfileLayout::class,
            HistoryLayout::class,
            Layouts::modals([
                'password' => [
                    ProfilePasswordLayout::class
                ],
            ])
        ];
    }
```

Now as we have our table displayed at the screen let's add an ability to filter it, to do it we create two filters:

```php
php artisan orchid:filter BrowserFilter
```

```php
namespace App\Http\Filters;

use App\History;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Screen\Field;
use Orchid\Platform\Filters\Filter;

class BrowserFilter extends Filter
{

    /**
     * @var array
     */
    public $parameters = [
        'browser'
    ];

    /**
     * @var bool
     */
    public $display = true;

    /**
     * @var bool
     */
    public $dashboard = true;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('browser', $this->request->get('browser'));
    }

    /**
     * @return mixed|void
     * @throws \Orchid\Press\TypeException
     */
    public function display() : Field
    {
        $browsers = History::select('browser')
                            ->groupBy('browser')
                            ->pluck('browser','browser');

        return Field::tag('select')
            ->options($browsers)
            ->value($this->request->get('browser'))
            ->name('browser')
            ->title('Browser')
            ->hr(false);
    }
}
```

An one more :

```php
namespace App\Http\Filters;

use App\History;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Screen\Field;
use Orchid\Platform\Filters\Filter;

class PlatformFilter extends Filter
{

    /**
     * @var array
     */
    public $parameters = [
        'platform'
    ];

    /**
     * @var bool
     */
    public $display = true;

    /**
     * @var bool
     */
    public $dashboard = true;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('platform', $this->request->get('platform'));
    }

    /**
     * @return mixed|void
     * @throws \Orchid\Press\TypeException
     */
    public function display() : Field
    {
        $platform = History::select('platform')
                            ->groupBy('platform')
                            ->pluck('platform','platform');

        return Field::tag('select')
            ->options($platform)
            ->value($this->request->get('platform'))
            ->name('platform')
            ->title('Platform')
            ->hr(false);
    }
}
```

Let's register our filters for our layout and access:

Add `filters` to `app/Layouts/HistoryLayout.php`
```php
    /**
     * @return array
     */
    public function filters() : array
    {
        return [
            BrowserFilter::class,
            PlatformFilter::class,
        ];
    }
```

Also define filters for access:

```php
    /**
     * Query data
     *
     * @return array
     */
    public function query(): array
    {
        $profile = Auth::user();
        $history = History::where('user_id', $profile->id)->filtersApply([
            BrowserFilter::class,
            PlatformFilter::class,
        ])->paginate();
 
        return compact('profile', 'history', 'statistics');
    }
```

Now we may select entries by browser and OS.

## Layout view and statistics

Let's add charts that will display user statistics:

```php 
php artisan orchid:chart BrowserLayout
``` 

With content:

```php
namespace App\Layouts;

use Orchid\Platform\Layouts\Chart;

class BrowserLayout extends Chart
{

    /**
     * @var string
     */
    public $title = 'Browsers used';

    /**
     * @var int
     */
    public $height = 200;

    /**
     * Available options:
     * 'bar', 'line', 'scatter',
     * 'pie', 'percentage'
     *
     * @var string
     */
    public $type = 'bar';

    /**
     * @var array
     */
    public $labels = [
        'Browsers',
    ];

    /**
     * @var string
     */
    public $data = 'statistics.browser';
}
```

And the same for `PlatformLayout`:

```php
namespace App\Layouts;

use Orchid\Platform\Layouts\Chart;

class PlatformLayout extends Chart
{

    /**
     * @var string
     */
    public $title = 'OSes used';

    /**
     * @var int
     */
    public $height = 200;

    /**
     * Available options:
     * 'bar', 'line', 'scatter',
     * 'pie', 'percentage'
     *
     * @var string
     */
    public $type = 'bar';

    /**
     * @var array
     */
    public $labels = [
        'Operational systems',
    ];

    /**
     * @var string
     */
    public $data = 'statistics.platform';
}
```

Now we redact the `query` method in our screen to define statistics data selection:

```php
    /**
     * Query data
     *
     * @return array
     */
    public function query(): array
    {
        $profile = Auth::user();
        $history = History::where('user_id', $profile->id)->filtersApply([
            BrowserFilter::class,
            PlatformFilter::class,
        ])->paginate();
        $statistics = [
            'browser'  => History::getStatisticsColumns("browser"),
            'platform' => History::getStatisticsColumns("platform"),
        ];
        
        return compact('profile', 'history', 'statistics');
    }
```


We register our charts in the screen and conjointly making our layout to look more appealing.

```php
    /**
     * Views
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layouts::columns([
                'User profile' => [
                    ProfileLayout::class,
                    Layouts::columns([
                        [PlatformLayout::class],
                        [BrowserLayout::class],
                    ])
                ],
                'History'              => [
                    HistoryLayout::class,
                ],
            ]),
            Layouts::modals([
                'password' => [
                    ProfilePasswordLayout::class
                ],
            ])
        ];
    }
```




## Source code

Finally we created the profile table using the screen mechanism of ORCHID.

Source code is available at [github](https://github.com/tabuna/tutorial_create_profile_for_orchid).


