<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Carbon\Carbon;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

class MetricsTest extends TestUnitCase
{

    public function testGroupCount(): void
    {
        factory(User::class, 5)->create([
            'uses_two_factor_auth' => true,
        ]);

        factory(User::class, 8)->create([
            'uses_two_factor_auth' => false,
        ]);

        $group = User::countForGroup('uses_two_factor_auth');

        $this->assertEquals(8, $group->pluck('value')->first());
        $this->assertEquals(5, $group->pluck('value')->last());

        $this->assertEquals([
            [
                'labels' => ['0', '1'],
                'values' => [8, 0],
            ],
            [
                'labels' => ['0', '1'],
                'values' => [0, 5],
            ],
        ], $group->toChart());


        $namedLabel = $group->toChart(static function (bool $title) {
            return $title ? 'Enabled' : 'Disabled';
        });

        $this->assertEquals([
            [
                'labels' => ['Disabled', 'Enabled'],
                'values' => [8, 0],
            ],
            [
                'labels' => ['Disabled', 'Enabled'],
                'values' => [0, 5],
            ],
        ], $namedLabel);
    }

    /**
     *
     */
    public function testPeriod(): void
    {
        $current = Carbon::now();
        $start = (clone $current)->subDay(2);
        $end = (clone $current)->subDay(1);

        factory(User::class, 5)->create([
            'created_at' => $start,
        ]);

        factory(User::class, 8)->create([
            'created_at' => $end,
        ]);

        $period = User::countByDays($start, $end);

        $this->assertEquals(5, $period->pluck('value')->first());
        $this->assertEquals(8, $period->pluck('value')->last());

        $this->assertEquals($start->toDateString(), $period->pluck('label')->first());
        $this->assertEquals($end->toDateString(), $period->pluck('label')->last());

        $this->assertEquals([
            'name'   => 'Users',
            'labels' => $period->pluck('label')->toArray(),
            'values' => $period->pluck('value')->toArray(),
        ], $period->toChart('Users'));
    }
}
