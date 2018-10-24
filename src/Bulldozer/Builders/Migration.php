<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Builders;

use Illuminate\Support\Facades\Artisan;

/**
 * Class Migration.
 */
class Migration
{
    public const TYPES = [
        1  => 'bigIncrements',
        2  => 'bigInteger',
        3  => 'binary',
        4  => 'boolean',
        5  => 'char',
        6  => 'date',
        7  => 'dateTime',
        8  => 'dateTimeTz',
        9  => 'decimal',
        10 => 'double',
        11 => 'enum',
        12 => 'float',
        13 => 'geometry',
        14 => 'geometryCollection',
        15 => 'increments',
        16 => 'integer',
        17 => 'ipAddress',
        18 => 'json',
        19 => 'jsonb',
        20 => 'lineString',
        21 => 'longText',
        22 => 'macAddress',
        23 => 'mediumIncrements',
        24 => 'mediumInteger',
        25 => 'mediumText',
        26 => 'morphs',
        27 => 'multiLineString',
        28 => 'multiPoint',
        29 => 'multiPolygon',
        30 => 'nullableMorphs',
        31 => 'nullableTimestamps',
        32 => 'point',
        33 => 'polygon',
        34 => 'smallIncrements',
        35 => 'smallInteger',
        36 => 'string',
        37 => 'text',
        38 => 'time',
        39 => 'timeTz',
        40 => 'tinyInteger',
        41 => 'timestamp',
        42 => 'timestampTz',
        43 => 'unsignedBigInteger',
        44 => 'unsignedInteger',
        45 => 'unsignedMediumInteger',
        46 => 'unsignedSmallInteger',
        47 => 'unsignedTinyInteger',
        48 => 'uuid',
    ];

    /**
     * @param string $name
     * @param string $schema
     *
     * @return int
     */
    public static function make(string $name, string $schema): int
    {
        $name = snake_case($name);
        $name = str_plural($name);
        $name = "create_{$name}_table";

        return Artisan::call('make:migration:schema', [
            'name'     => $name,
            '--schema' => $schema,
        ]);
    }
}
