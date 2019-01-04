# Вложения
----------


Вложения - это файлы, относящиеся к записи.
Эти файлы могут быть разных форматов и разрешений.
Каждый формат можно вызывать отдельно, например, принимать только изображения или только документы в записи.


Вложения могут быть прикреплены к любой модели посредством связей, для этого необходимо добавить трейд:

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\Attachment;

class Hostel extends Model
{
    use Attachment;
    //
}
```

После этого мы можем добавлять и получать её вложения, например:

```php
$item = Hostel::find(42);
$item->attachment()->get();
```

По-умолчанию вложение имеет следующие свойства:

```php
 [
    'name' => 'Системное имя',
    'original_name' => 'Оригинальное имя',
    'mime' => 'MIME тип',
    'extension' => 'Расширение файла',
    'size' => 'Размер файла',
    'path' => 'Путь',
    'user_id' => 'Номер пользователя загрузивший запись',
    'description' => 'Описание файла',
    'alt' => 'Альтернативное название файла',
    'hash' => 'Хеш файла',
    'disk' => 'Указатель на диск, где распологается файл',
];
```


## Пример загрузки

В действительности вы уже имеете маршрут для загрузку файлов (если конечно, к нему разрешён доступ)

Пример метода контроллера:

```php
use Orchid\Platform\Attachments\File;

public function upload(Request $request)
{
    $file = new File($request->file('photo'));
    $attachment = $file->load();

    return response()->json()
}
```

Это автоматически загрузит ваш файл в хронилище по умолчанию (`public`) и создаст запись в базе данных.


```php
$image = $item->attachment('image')->first();

//Возвращает общий адрес изображения с требуемым разрешением изображения
$image->url('standart');
```

Все новые изображения создаются согласно простым шаблонам,
 которые позволяют менять разрешение, качество, ориентацию, добавлять водяные знаки и многое другое.
Каждый шаблон имеет в своей основе расширение `Intervention Image`.

## Повторная загрузка

Благодаря хешу, вложения не загружаются повторно, вместо этого создаётся ссылка в базе данных на необходимый физический файл,
позволяя эффективно использовать ресурсы. Файл будет удалёт только тогда, когда все ссылки будут уничтожены.


## Подписка на загрузку

Различные варианты обработки файлов могут потребовать дополнительной обработки, например, сжатие видео,
это возможно благодаря событию, на которое можно подписаться стандартными средствами и выполнить задачу в фоне:

```php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listener\UploadListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UploadFileEvent::class => [
             UploadListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
```

Каждая подписка получит объект `UploadFileEvent`:

```php
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Orchid\Platform\Events\UploadFileEvent;

class UploadListener extends ShouldQueue
{
    use InteractsWithQueue;
    
    /**
     * Handle the event.
     *
     * @param  UploadFileEvent  $event
     * @return void
     */
    public function handle(UploadFileEvent $event)
    {
        //$event->attachment
        //$event->time
    }
}
``` 
