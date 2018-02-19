# Использование экранов
----------

Этот документ является учебным пошаговом руководством в котором демонстрируется процесс создания профиля с помощью `Экранов`.
Примеры специально подобраны для того, чтобы помочь новичку справляться с задачами от начала до конца.



## Установка

Для начало [установим](/ru/docs/installation) сам Laravel и пакет ORCHID

## Миграции

Выполним изменение схемы данных, чтобы она содержала `Фамилию`, `Имя` и логирование авторизаций.

Для этого выполним команду:
```php
php artisan make:migration create_table_users_history
```

Это команда создаст новый файл в директории `database/migrations`, приведем его к виду:

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


Также создадим второй файл миграции относящийся непосредственно к пользователю:

```php
php artisan make:migration create_fields_for_users
```

С содержанием:

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


Применим все созданные миграции с помощью команды:

```php
php artisan migrate
```


## Модели данных


Как только мы создали и применили необходимые миграции, нам необходимо создать\изменить модели.
Для этого создадим новую модель с помощью:

```php 
php artisan make:model History
```

В директории `app`, будет создан файл `History.php`, опишем его следующим образом:

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Core\Traits\FilterTrait;
use Orchid\Platform\Core\Traits\MultiLanguage;

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

В данной модели, мы описали: таблицу, поля для авто-заполнения, связь один ко многим и метод для получения статистики по колонке.

Нам также потребуется обновить модель User:

```php
namespace App;

use Orchid\Platform\Core\Models\User as BaseUser;

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

## Логирование авторизации

Для сбора информации о браузере и используемой операционной системы будем использовать пакет `Agent`, для его установки выполним:

```php
composer require jenssegers/agent
```

Для того, чтобы логировать авторизацию создадим слушатель `app/Listeners/UserEventSubscriber.php`:

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

И зарегистрируем его в `app/Providers/EventServiceProvider.php`:

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


Теперь при каждой успешной авторизации в базу данных будет записана вся необходимая информация, которую мы сможем использовать в будущем.


## Создание экрана

ORCHID в стандартной поставки не имеет профиля пользователя, поэтому сделаем его самостоятельно с помощью `Экрана`, для этого выполним:

```php
php artisan make:screen ProfileScreen
```

Artisan создаст файл в директории `app/Http/Controllers/Screens`, если вы опытный пользователь, то рекомендуется изменить данный каталог на  `app/Http/Screens`,

Добавим наш новый экран в файл маршрутизации `routes/web.php`:

```php
Route::screen('/dashboard/profile', 'Screens\ProfileScreen','dashboard.screens.profile');
```


## Регистрация экрана в меню

Для отображения нашего экрана в меню элементов необходимо добавить регистрации `View::composer` в `app/Providers/AppServiceProvider.php`

Создадим класс регистрации `app/Http/Composers/MenuComposer.php`:

```php
namespace App\Http\Composer;

use Orchid\Platform\Kernel\Dashboard;

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
            'route'  => route('dashboard.screens.profile'),
            'label'  => 'Профиль',
            'childs' => false,
            'main'   => true,
            'sort'   => 6000,
        ]);
    }
}
```

И зарегистрируем его в нашем сервис провайдере `app/Providers/AppServiceProvider.php`:
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
        View::composer('dashboard::layouts.dashboard', MenuComposer::class);
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


Теперь наш экран отображается в меню, перейдём к его наполнению.

## Создание AJAX виджета данных

Многие могли заметить, что в миграциях мы добавили новый столбец у пользователя `city_id`, но не создавали модель городов.
Для нашего, примера, отлично подойдёт обычный файл конфигурации laravel.

Создадим новый файл `config/city.php` и наполним его некоторыми городами России:

```php
return [

    'list' => [
        [
            'id'   => 0,
            'text' => 'Москва',
        ],
        [
            'id'   => 1,
            'text' => 'Санкт-Петербург',
        ],
        [
            'id'   => 2,
            'text' => 'Новосибирск',
        ],
        [
            'id'   => 3,
            'text' => 'Екатеринбург',
        ],
        [
            'id'   => 4,
            'text' => 'Нижний Новгород'
        ],
    ]
];
```

Создадим виджет, для того, чтобы в будущем передавать их по запросу, для этого создадим новый виджет:

```php
php artisan make:widget CityWidget
```

Новый файл будет создан в `app/Http/Widgets/CityWidget.php`, в отличии от виджетов для шаблонов, нам нет нужды регистрировать его.

Изменим его, чтобы он всегда передавал массив параметров:

```php
namespace App\Http\Widgets;

use Orchid\Platform\Widget\Widget;

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

Мы воспользовались коллекциями для того, чтобы иметь возможность поиска по `id` и названию нашего города.

Не обязательно использовать хранилищем параметры конфигурации, это может быть и модель городов или даже API.


## Создание базового макета профиля

Чтобы дать возможность менять данные своего профиля необходимо генерировать форму с полями для ввода, для этого создадим новый макет строки:

```php
php artisan make:row ProfileLayout
```

Добавим поля которые мы хотим менять у пользователя в новом файле `app/Layouts/ProfileLayout.php`:


```php
namespace App\Layouts;

use App\Http\Widgets\CityWidget;
use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class ProfileLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {
        return [

            Field::tag('picture')
                ->name('profile.avatar')
                ->title('Аватар')
                ->width(200)
                ->height(200),

            Field::tag('input')
                ->name('profile.name')
                ->required()
                ->title('Псевдоним'),

            Field::tag('input')
                ->name('profile.email')
                ->required()
                ->readonly()
                ->disable()
                ->title('Электронная почта'),

            Field::tag('input')
                ->name('profile.first_name')
                ->required()
                ->title('Имя'),

            Field::tag('input')
                ->name('profile.last_name')
                ->required()
                ->title('Фамилия'),

            Field::tag('relationship')
                ->name('profile.city_id')
                ->required()
                ->title('Город')
                ->handler(CityWidget::class),

        ];
    }
}
```

Теперь необходимо указать, что мы будем использовать его в нашем экране профиля:

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
    public $name = 'Профиль';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Полное управление пользователем в одном месте';

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

Источником всех наших данных выступает метод `query`, по этому мы должны передать массив общих данных, вы могли заметить, что 
при описании шаблона мы использовали имена `profile.`, это значит, что данные будут браться из ключа `profile`.


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

Отлично, теперь мы можем видеть все поля формы, добавим кнопку по нажатию на которой форма будет сохраняться.

Для этого в метод `commandBar` добавим:

```php
    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name('Обновить профиль')
                ->method('update')
        ];
    }

```

Это добавит кнопку в нашем экране по нажатию на которой будет выполнен метод `update` в нашем экране.

Добавим такой метод в наш файл:

```php

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        Auth::user()->fill($request->get('profile'))->save();

        Alert::info('Профиль успешно обновлён');
        return redirect()->back();
    }
```

Отлично, теперь мы можем не только отображать необходимую информацию, но и изменять её.


## Создание окна смены пароля

Наш экран профиля будет не полным без возможности смены пароля, так сделаем же её!

Для этого, потребуется создать новый макет:

```php
php artisan make:row ProfilePasswordLayout
```

Содержащий только поля `пароль` и `повторите пароль`:

```php
namespace App\Layouts;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class ProfilePasswordLayout extends Rows
{
    /**
     * Views
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields(): array
    {
        return [
            Field::tag('password')
                ->name('profile.password')
                ->required()
                ->title('Введите пароль'),

            Field::tag('password')
                ->name('profile.password_confirmation')
                ->required()
                ->title('Повторите пароль')
                ->hr(false),

        ];
    }
}
```


А в нашем экране зарегистрируем его в модальном окне:

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

Мы объявили группу модальных окон, в котором будет один единственный макет.

Добавим кнопку:

```php

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name('Изменить пароль')
                ->modal('password')
                ->title('Смена пароля')
                ->method('changePassword'),
            Link::name('Обновить профиль')
                ->method('update')
        ];
    }
```

Теперь при нажатии на кнопку `Изменить пароль` будет показано модальное окно с нашим шаблоном.
Как мы помним из предыдущих шагов метод `method` отвечает, за выполнение при нажатие.


```php
    /**
     * @param ChangePassword $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(ChangePassword $request)
    {
        Auth::user()->password = Hash::make($request->input('profile.password'));
        Auth::user()->save();

        Alert::info('Ваш пароль успешно изменён');
        return redirect()->back();
    }
```

Отлично, наша экран профиля почти готов.



## Создание шаблона с историей

Добавим таблицу в которой будут данные о том, с каких устройств происходила авторизация, для этого создадим макет таблицы:

```php
php artisan make:table HistoryLayout
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
                ->title('Дата входа')
                ->width('150px')
                ->setRender(function ($item){
                return $item->created_at->toDateString();
            }),

            TD::name('address')
                ->width('150px')
                ->title('IP Адрес'),


            TD::name('platform')
                ->width('200px')
                ->title('Платформа')
                ->setRender(function ($item){
                $platform_version = $item->platform_version;
                if(!$platform_version || $platform_version === 'unknown'){
                    $platform_version = "";
                }

                return "{$item->platform} {$platform_version}";
            }),

            TD::name('browser')
                ->title('Браузер')
                ->setRender(function ($item){
                return "{$item->browser} {$item->browser_version}";
            }),
        ];
    }
}
```


Необходимо передать зарегистрировать шаблон в экране и передать данные:

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

Теперь наша таблица отображается на экране, добавим возможность фильтрации для этого создадим два фильтра:

```php
php artisan make:filter BrowserFilter
```

```php
namespace App\Http\Filters;

use App\History;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Platform\Fields\Field;
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
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function display() : Field
    {
        $browsers = History::select('browser')->groupBy('browser')->pluck('browser','browser');

        return Field::tag('select')
            ->options($browsers)
            ->value($this->request->get('browser'))
            ->name('browser')
            ->title('Браузер')
            ->hr(false);
    }
}
```

И такой же :

```php
namespace App\Http\Filters;

use App\History;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Platform\Fields\Field;
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
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function display() : Field
    {
        $platform = History::select('platform')->groupBy('platform')->pluck('platform','platform');

        return Field::tag('select')
            ->options($platform)
            ->value($this->request->get('platform'))
            ->name('platform')
            ->title('Платформа')
            ->hr(false);
    }
}
```

Зарегистрируем наши фильтры в шаблоне и выборки:

Добавим метод `filters` в `app/Layouts/HistoryLayout.php`
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

Также укажем фильтры для выборки:

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

Теперь мы можем делать выборки по браузеру и операционной системы.

## Внешний вид и статистика

Добавим графики которые бы отображали статистику использования:

```php 
php artisan make:chart BrowserLayout
``` 

С содержанием:

```php
namespace App\Layouts;

use Orchid\Platform\Layouts\Chart;

class BrowserLayout extends Chart
{

    /**
     * @var string
     */
    public $title = 'Используемые браузеры';

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
        'Браузеры',
    ];

    /**
     * @var string
     */
    public $data = 'statistics.browser';
}
```

И такой же `PlatformLayout`:

```php
namespace App\Layouts;

use Orchid\Platform\Layouts\Chart;

class PlatformLayout extends Chart
{

    /**
     * @var string
     */
    public $title = 'Используемые платформы';

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
        'Операционные системы',
    ];

    /**
     * @var string
     */
    public $data = 'statistics.platform';
}
```

Снова отредактируем метод `query` в нашем экране, чтобы выбрать данные для статистики:

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


Зарегистрируем наши графики в экране и заодно сделаем существующий внешний вид более привлекательным.

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
                'Профиль пользователя' => [
                    ProfileLayout::class,
                    Layouts::columns([
                        [PlatformLayout::class],
                        [BrowserLayout::class],
                    ])
                ],
                'История'              => [
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




## Исходный код

Итого мы создали страницу профиля с использованием механизма экранов ORCHID.

Исходный код доступен на [github](https://github.com/tabuna/tutorial_create_profile_for_orchid).


