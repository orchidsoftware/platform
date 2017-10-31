# Резервные копии
----------

Резервная копия - это zip-файл, содержащий все файлы в указанных вами каталогах вместе с дампом вашей базы данных.

Резервное копирование файлов и баз данных очень просто. Просто выпустите эту команду artisan:

```php
php artisan backup:run
```


Для дополнительной безопасности добавьте резервную копию в расписание

```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
   $schedule->command('backup:clean')->daily()->at('00:00');
   $schedule->command('backup:run')->daily()->at('01:00');
}
```

