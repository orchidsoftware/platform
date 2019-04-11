# Меню панели платформы
----------

Меню панели платформы - это важный элемент графического интерфейса пользователя, потому, что спомощью него осуществляется основаня навигация по проекту.


Для того, что бы добавить новый элемент в меню, нужно сообщить об этом нашему приложению `Dashboard`,
для этого вызвать метод в свойство меню и передать аргументы: 

* Название меню к которому необходимо прикрипить элемент
* Обьект меню содержищий название, ссылки и т.п.

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
        $dashboard->menu->add(Menu::MAIN,
            ItemMenu::label('Idea')
                ->icon('icon-bubbles')
                ->url('#')
                //->route('platform.systems.idea')
                //->permission('platform.systems.idea')
                ->sort(1000)
                ->groupName('idea')
                ->badge(function () {
                    return 10;
                })
        );
    }
}
```
	
