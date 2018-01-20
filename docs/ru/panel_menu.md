# Меню панели

Меню панели - это элемент интерфейса администратора,
Позволяет выбрать один из нескольких перечисленных вариантов программного обеспечения.
Это важный элемент графического интерфейса пользователя.


Для того, что бы добавить новый элемент в меню, нужно сообщить об этом нашему приложению `Dashboard`,
для этого вызвать метод в свойство меню и передать аргументы: 
элемент меню, к которому будет добавляться наш элемент (Главным меню служит 'Main')
и массив содержащий свойства элемента. 

```php
'slug'       => 'Уникальная строка содержащая только безопасные символы',
'icon'       => 'CSS код для графической иконки',
'route'      => 'Путь, route() или ссылка',
'label'      => 'Название',
'childs'     => 'Может ли пункт иметь дочерние элементы true/false',
'main'       => 'Является ли пункт главным true/false',
'active'     => 'На каких страницах меню должно быть активным /dashboard.mymenu.*',
'permission' => 'Какими правами должен обладать пользователь /dashboard.mymenu',
'sort'       => 'Сортировка элементов 1/2/3/4',
'show'       => 'Условия показа true/false',
```


Чтобы зарегистрировать новое меню для своего пакета или модуля, вам необходимо
указать его в поставщике композитора.
	

## Регистрация в сервис провайдере
Зарегистрировать новый элемент меню можно несколькими способами, например прямо в `ServiceProvider`.


Например изменим `app/Providers/AppServiceProvider.php` в такой вид:
	
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Orchid\Platform\Kernel\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard->menu->add('Main', [
            'slug'       => 'slug-my-menu',
            'icon'       => 'icon-anchor',
            'route'      => '#',
            'label'      => 'My menu',
            'childs'     => true,
            'main'       => true,
            //'active'     => 'dashboard.mymenu.*',
            //'permission' => 'dashboard.mymenu',
            'badge'      => [
                'class' => 'bg-primary',
                'data' => function(){
                    return 7;
                }
            ],
            'sort'       => 1,
        ]);
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
	
	
## Регистрация с помощью композитора	
	
Предпочтительнее регистрировать все пункты меню с помощью `View::composer` для этого создайте класс
`app/Http/Composer/MenuComposer.php`:


	
```php
namespace App\Http\Composer;

use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Kernel\Dashboard;
use Orchid\Platform\Notifications\DashboardNotification;

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
            'slug'   => 'Сustom',
            'icon'   => 'icon-drop',
            'route'  => '#',
            'label'  => 'Сustom',
            'childs' => true,
            'main'   => true,
            'sort'   => 6000,
        ]);

        $this->dashboard->menu->add('Сustom', [
            'slug'      => 'Element',
            'icon'      => 'icon-user-female',
            'route'     => '#',
            'label'     => 'Element 1',
            'groupname' => 'Сustom group',
            'divider'   => false,
            'childs'    => false,
            'sort'      => 1,
            'badge'     => [
                'class' => 'bg-dark',
                'data'  => function () {
                    return 9;
                },
            ],
        ]);

        $this->dashboard->menu->add('Сustom', [
            'slug'    => 'Element2',
            'icon'    => 'icon-location-pin',
            'route'   => '#',
            'label'   => 'Element 2',
            'divider' => false,
            'childs'  => false,
            'sort'    => 1,
            'badge'   => [
                'class' => 'bg-primary',
                'data'  => function () {
                    return 1;
                },
            ],
        ]);

        $this->dashboard->menu->add('Сustom', [
            'slug'    => 'Element3',
            'icon'    => 'icon-energy',
            'route'   => '#',
            'label'   => 'Element 3',
            'divider' => false,
            'badge'   => [
                'class' => 'bg-danger',
                'data'  => function () {
                    return 2;
                },
            ],
            'childs'  => false,
            'sort'    => 1,
        ]);

        $this->dashboard->menu->add('Сustom', [
            'slug'    => 'Element4',
            'icon'    => 'icon-playlist',
            'route'   => '#',
            'label'   => 'Element 4',
            'divider' => true,
            'childs'  => false,
            'sort'    => 1,
            'badge'   => [
                'class' => 'bg-info',
                'data'  => function () {
                    return 5;
                },
            ],
        ]);

        $this->dashboard->menu->add('Сustom', [
            'slug'      => 'Element5',
            'icon'      => 'icon-docs',
            'route'     => '#',
            'label'     => 'Element 5',
            'groupname' => 'Сustom group',
            'divider'   => true,
            'childs'    => true,
            'sort'      => 1,
        ]);

        $this->dashboard->menu->add('Сustom', [
            'slug'    => 'Element7',
            'icon'    => 'icon-playlist',
            'route'   => '#',
            'label'   => 'Element 7',
            'divider' => true,
            'childs'  => false,
            'sort'    => 1,
        ]);

        $this->dashboard->menu->add('Сustom', [
            'slug'    => 'Element8',
            'icon'    => 'icon-cup',
            'route'   => '#',
            'label'   => 'Element 8',
            'divider' => true,
            'childs'  => false,
            'sort'    => 1,
        ]);

        for ($i = 1; $i < 15; $i++) {
            $this->dashboard->menu->add('Element5', [
                'slug'    => 'Element9.' . $i,
                'icon'    => 'icon-bulb',
                'route'   => '#',
                'label'   => 'Element 9.' . $i,
                'divider' => false,
                'childs'  => false,
                'sort'    => 1,
            ]);
        }
    }
}
```


Теперь требуется зарегистрировать композер в сервис провайдере
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Composer\MenuComposer;
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


## Собственные меню

Принцип работы меню можно свести к группировкам схожих элементов и вывода рекурсии каждой группы по запросу (Примеры добавления указаны выше).

Вызвать рендеринг меню в шаблоне можно с помощью фасада `Dashbord` и передать два аргумента
название группы которую нужно отобразить и название шаблона который будет строить визуальное отображение.

```php
{!! Dashboard::menu()->render('Main','dashboard::partials.leftMainMenu') !!}
```
