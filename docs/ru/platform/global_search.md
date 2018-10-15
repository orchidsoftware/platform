# Глобальный поиск
----------

## Использование

Добавить трейт `Orchid\Platform\Traits\GlobalSearchTrait` к модели, добавленный трейд уже включает в себя `Laravel Scout`

Как пример модель может выглядеть так:
```php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\GlobalSearchTrait;

class Product extends Model
{
    use GlobalSearchTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'photo', 'price'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }
}

```

В результатах поиска могут быть указаны следующие параметры:
- **label** - Является группой, например: новости, пользователи и т.п.
- **titile** - Главная строка текста, например, фамилия и имя пользователя
- **subTitile** - дополнительная строка, например, должность, статус
- **url**  - доступная ссылка для перехода/редактирования
- **avatar** - Изображения


## Модификация

По умолчанию из модели будут браться указанные атрибуты. Для того, что бы определить какие данные будут передаваться, указываются методы с префиксом `search` в явном виде, например:

```php
/**
 * @return string
 */
public function searchLabel(): ?string;

/**
 * @return string
 */
public function searchTitle(): ?string

/**
 * @return string
 */
public function searchSubTitle(): ?string

/**
 * @return string
 */
public function searchUrl(): ?string

/**
 * @return string
 */
public function searchAvatar(): ?string
```

Для модификации запросов, например, выдавать в результатах, только актуальные данные, можно модифицировать запрос с помощью переопределения метода:

```php
public function searchQuery(string $query = null) : LengthAwarePaginator
```


## Регистрация


```php
class PlatformProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard->registerGlobalSearch([
          //...Models
        ]);
    }
}
```