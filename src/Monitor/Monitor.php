<?php

namespace Orchid\Monitor;

use stdClass;

class Monitor
{
    /**
     * @var
     */
    public $server;

    /**
     * Monitor constructor.
     */
    public function __construct()
    {
        $this->server = $_SERVER;
    }

    /**
     * The array $_SERVER[] contains a bunch of server and execution
     * environment information.
     *
     * Reading /proc/cpuinfo to find out the type of processor this
     * is running on.
     *
     * @return \stdClass
     */
    public function info(): stdClass
    {
        // preparing cpu info
        $uname = shell_exec('uname -r ');
        $nameFull = trim(preg_replace('/\s\s+/', ' ', shell_exec('cat /proc/cpuinfo | grep name | head -1')));
        $name = explode(': ', $nameFull);

        //determine php version
        $phpVersion = explode('.', phpversion());

        // data object
        $data = new stdClass();

        $serverAddr = (isset($this->server['SERVER_ADDR'])) ? $this->server['SERVER_ADDR'] : ' ';

        $data->uname = $uname;
        $data->webserver = $this->server['SERVER_NAME'] . ' (' . $serverAddr . ') - ' . $this->server['SERVER_SOFTWARE'];
        $data->phpVersion = 'PHP/' . $phpVersion[0] . '.' . $phpVersion[1] . '.' . $phpVersion[1];
        $data->cpu = $name[1];

        return $data;
    }

    /**
     * Using the onboard temperature sensor and the command 'uptime'
     * to pull in information about how hot the Raspberry Pi is and
     * how long it's been switched on for.
     *
     * @return \stdClass
     */
    public function hardware(): stdClass
    {
        $output = (float)shell_exec('cat /sys/class/thermal/thermal_zone0/temp');
        $temp = round(($output) / 1000, 1);
        $output = (float)shell_exec('echo "$(</proc/uptime awk \'{print $1}\')"');
        $timeAlive = StringHelpers::secondsToTime((int)$output);

        // data object
        $data = new stdClass();
        $data->temperature = $temp;
        $data->uptime = $timeAlive;

        return $data;
    }

    /**
     * The command uptime returns a bunch of information about how long
     * the system has been running and the load on the processor. Read
     * more about this information here
     *   - http://www.computerhope.com/unix/uptime.htm.
     *
     * @return \stdClass
     */
    public function loadAverage(): stdClass
    {
        $output = shell_exec('uptime');
        $loadavg = explode(' ', substr($output, strpos($output, 'load average:') + 14));

        // data object
        $data = new stdClass();
        $data->oneMin = StringHelpers::prettyLoadAverage($loadavg[0]);
        $data->fiveMins = StringHelpers::prettyLoadAverage($loadavg[1]);
        $data->fifteenMins = StringHelpers::prettyLoadAverage($loadavg[2]);

        return $data;
    }

    /**
     * Check out this page to find out how to understand
     * the output of the free command:
     *   - http://www.linuxnix.com/find-ram-size-in-linuxunix/.
     *
     * The code below pulls the relevant parts out of 'free'
     * and figures out the percentage used of each.
     *
     * $totalAct is a little less than $memTotal as there's
     * some used up by the bootloader that's not available
     * to the system.
     *
     * @return stdClass
     */
    public function memory(): stdClass
    {
        //$mem_free = (int)shell_exec("free -m | awk '/buffers\/cache/ {print $3}'");
        $memTotal = (int)shell_exec("free -m | awk '/Mem/ {print $2}'");
        $memTotal = ($memTotal) ? $memTotal : 1;
        $usedAct = (int)shell_exec("free | awk '/buffers\/cache/ {print $3}'");
        $usedAct = ($usedAct) ? $usedAct : 1;
        $free = (int)shell_exec("free | awk '/Mem/ {print $4}'");
        $free = ($free) ? $free : 1;
        $buffers = (int)shell_exec("free | awk '/Mem/ {print $6}'");
        $buffers = ($buffers) ? $buffers : 1;
        $cache = (int)shell_exec("free | awk '/Mem/ {print $7}'");
        $cache = ($cache) ? $cache : 1;
        $totalAct = $usedAct + $free + $buffers + $cache;
        $free_p = 100 * ($free / $totalAct);
        $buffersPercent = 100 * ($buffers / $totalAct);
        $cachePercent = 100 * ($cache / $totalAct);
        $usedAct_p = 100 * ($usedAct / $totalAct);
        // data object
        $data = (object)[
            'total'   => (object)[
                'pretty' => StringHelpers::prettyMemory($memTotal),
                'actual' => $totalAct,
            ],
            'used'    => (object)[
                'pretty'     => (string)round($usedAct_p, 2),
                'percentage' => $usedAct_p,
                'actual'     => $usedAct,
            ],
            'buffers' => (object)[
                'pretty'     => (string)round($buffersPercent, 2),
                'percentage' => $buffersPercent,
                'actual'     => $buffers,
            ],
            'cache'   => (object)[
                'pretty'     => (string)round($cachePercent, 2),
                'percentage' => $cachePercent,
                'actual'     => $cache,
            ],
            'free'    => (object)[
                'pretty'     => (string)round($free_p, 2),
                'percentage' => $free_p,
                'actual'     => $free,
            ],
        ];

        return $data;
    }

    /**
     * There is a custom script alongside this project called 'uptime'
     * which figures out the amount of data going through the network
     * in the past second. This script takes one second to execute so
     * will delay the loading of the page accordingly.
     *
     * Also using one of the scripts in lib/string_helpers.php to
     * print the network speed in either b/s, Kb/s or Gb/s.
     *
     * @return stdClass
     */
    public function network(): stdClass
    {
        $output = shell_exec('sh ' . __DIR__ . '/transfer_rate.sh');
        $rates = explode(' ', $output);
        // data object
        $data = new stdClass();
        $data->down = StringHelpers::prettyBaud((int)$rates[0]);
        $data->up = StringHelpers::prettyBaud((int)$rates[1]);

        return $data;
    }

    /**
     * The commands df -H returns a bunch of useful information
     * about how your connected storage is utilised. The following
     * loops through the output of this data and does different
     * things depending on which column of the table it's on.
     *
     * @return \stdClass
     */
    public function storage(): stdClass
    {
        $output = shell_exec('df -H');
        $table_rows = preg_split('/$\R?^/m', $output);
        $table_rows = array_splice($table_rows, 1);

        // data object
        $data = new stdClass();
        $data->storage = array_map([$this, 'prepareColumns'], $table_rows);

        return $data;
    }

    /**
     * @param string $row
     *
     * @return array
     */
    private function prepareColumns(string $row): array
    {
        return array_values(array_filter(explode(' ', $row), 'strlen'));
    }
}
