#System Monitor
----------

Monitor will show you current information about your server:

* Board temperature
* Network status
* Uptime
* CPU Load
* Memory allocation
* Available storage

The monitor uses specific functions and is available only under  **Unix** operating systems

### Usage

```php
use Orchid\Monitor\Monitor;

$monitor = new Monitor();

//uname,webserver,phpVersion,cpu
$monitor->info();

//temperature,uptime
$monitor->hardware();

//oneMin,fiveMins,fifteenMins
$monitor->loadAverage();

//total,used,buffers,cache
$monitor->memory();

//down,up
$monitor->network();

//array
$monitor->storage();
```
