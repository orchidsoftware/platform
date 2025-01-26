<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Support\Formats;
use Orchid\Support\Init;
use Orchid\Tests\TestUnitCase;

class SupportFormatsTest extends TestUnitCase
{
    public function test_unix_date_to_time_string(): void
    {
        $this->assertEquals('2018-05-07 23:30:20', Formats::toDateTimeString(1525735820));
    }

    public function test_format_bytes(): void
    {
        $this->assertEquals(0, Formats::formatBytes(0));
        $this->assertEquals('1000 bytes', Formats::formatBytes(1000));
        $this->assertEquals('1.95 KB', Formats::formatBytes(2000));
        $this->assertEquals('9.54 MB', Formats::formatBytes(10000000));
        $this->assertEquals('931.32 GB', Formats::formatBytes(1000000000000));
        $this->assertEquals('9.09 TB', Formats::formatBytes(10000000000000));
    }

    public function test_convert_bytes(): void
    {
        $bytes = Init::toBytes('1G');

        $this->assertEquals(1048576, Init::convertBytesTo(Init::KB, $bytes));
        $this->assertEquals(1024, Init::convertBytesTo(Init::MB, $bytes));
        $this->assertEquals(1, Init::convertBytesTo(Init::GB, $bytes));

        $bytes = Init::toBytes('2M');

        $this->assertEquals(2048, Init::convertBytesTo(Init::KB, $bytes));
        $this->assertEquals(2, Init::convertBytesTo(Init::MB, $bytes));
        $this->assertEquals(0, Init::convertBytesTo(Init::GB, $bytes));

        $bytes = Init::toBytes('128K');

        $this->assertEquals(128, Init::convertBytesTo(Init::KB, $bytes));
        $this->assertEquals(0, Init::convertBytesTo(Init::MB, $bytes));
        $this->assertEquals(0, Init::convertBytesTo(Init::GB, $bytes));
    }
}
