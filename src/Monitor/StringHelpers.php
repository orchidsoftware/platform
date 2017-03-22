<?php

namespace Orchid\Monitor;

class StringHelpers
{
    /**
     * Convert a number of seconds into the
     * Days-Hours-Minutes format.
     *
     * @param int $seconds
     *
     * @return string
     */
    public static function secondsToTime(int $seconds): string
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");

        return $dtF->diff($dtT)->format('%ad %hh %im');
    }

    /**
     * Take a number of bytes and return it
     * either in terms of Gigs or Megs.
     *
     * @param int $total
     *
     * @return string
     */
    public static function prettyMemory(int $total): string
    {
        $total = (int) $total;

        if ($total > 999) {
            $total = round($total / 1024, 2);

            return "{$total} GB";
        }

        return "{$total} MB";
    }

    /**
     * Figure out of the baud rate should be
     * shown as MB/s, Kb/s or b/s.
     *
     * @param int $baud
     *
     * @return string
     */
    public static function prettyBaud(int $baud): string
    {
        if ($baud > 1000000) {
            $baud = round($baud / 1000000, 2);

            return "$baud Mb/s";
        } elseif ($baud > 1000) {
            $baud = round($baud / 1000, 2);

            return "$baud Kb/s";
        }

        return "$baud b/s";
    }

    /**
     * Take in the load_average as returned by the
     * uptime command and return it as a percentage
     * with the appropriate formatting.
     *
     * @param string $load_average
     *
     * @return array
     */
    public static function prettyLoadAverage(string $load_average): array
    {
        $load_average = substr($load_average, 0, -1);
        $avg_percent = $load_average * 100;

        return ['average' => $load_average, 'percent' => $avg_percent];
    }
}
