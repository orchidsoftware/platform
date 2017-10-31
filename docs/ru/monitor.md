
# Системный Монитор
----------

Монитор покажет вам текущую информацию о вашем сервере:

* Температура процессора
* Статус сети
* Время работы
* Загрузка процессора
* Выделение памяти
* Доступное хранилище

Монитор использует функции системы и доступен только в операционных системах **Unix**


### Использование

```php
use Orchid\Monitor\Monitor;

$monitor = new Monitor();

// uname,webserver,phpVersion,cpu
$monitor->info();

// temperature,uptime
$monitor->hardware();

// oneMin,fiveMins,fifteenMins
$monitor->loadAverage();

// total,used,buffers,cache
$monitor->memory();

// down,up
$monitor->network();

// array
$monitor->storage();
```
