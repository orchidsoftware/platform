#Backups
----------

The backup is a zipfile that contains all files in the directories you specify along with a dump of your database. 


Backup of your files and databases is very easy. Just issue this artisan command:

```php
php artisan backup:run
```


For added security, add a backup to the schedule

```php
//app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
   $schedule->command('backup:clean')->daily()->at('00:00');
   $schedule->command('backup:run')->daily()->at('01:00');
}
```

