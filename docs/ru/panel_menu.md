# Меню панели платформы
----------

Меню панели платформы - это элемент интерфейса администратора,
позволяет выбрать один из нескольких перечисленных вариантов программного обеспечения.
Это важный элемент графического интерфейса пользователя, потому, что спомощью него осуществляется основаня навигация по проекту.


Для того, что бы добавить новый элемент в меню, нужно сообщить об этом нашему приложению `Dashboard`,
для этого вызвать метод в свойство меню и передать аргументы: 
элемент меню, к которому будет добавляться наш элемент (Главным меню служит 'Main')
и массив содержащий свойства элемента. 


## Пример записи

Регистрация меню по умолчанию происходит в директории `app/Orchid/Composers`, но можно указывать прямо в `ServiceProvider`.
Например, изменим `app/Providers/AppServiceProvider.php` в такой вид:
	
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Orchid\Platform\Dashboard;

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
        $dashboard->menu->add('Main',
            ItemMenu::setLabel('Idea')
                ->setIcon('icon-bubbles')
                ->setRoute('#')
                //->setPermission('platform.systems.idea')
                ->setSort(1000)
                ->setGroupName('idea')
                ->setBadge(function () {
                    return 10;
                })
        );
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
{!! Dashboard::menu()->render('Main','platform::partials.leftMainMenu') !!}
```
