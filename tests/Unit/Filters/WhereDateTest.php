<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Filters;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\WhereDate;
use Orchid\Tests\TestUnitCase;

class WhereDateTest extends TestUnitCase
{
    private function getModelBuilder(): \Illuminate\Database\Eloquent\Builder
    {
        $model = new class extends Model
        {
            use Filterable;

            protected $allowedFilters = [
                'WhereDate' => WhereDate::class,
            ];
        };

        return $model->filters();
    }

    public function testWhereDate(): void
    {
        request()->merge([
            'filter' => [
                'WhereDate' => '2023-01-15',
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('WhereDate', $sql);
    }

    public function testWhereDateChecksBindings(): void
    {
        request()->merge([
            'filter' => [
                'WhereDate' => '2023-01-15',
            ],
        ]);

        $builder = $this->getModelBuilder();

        $this->assertContains('2023-01-15', $builder->getBindings());
    }

    public function testWhereDateNotAppliedWhenNoFilter(): void
    {
        $sql = $this->getModelBuilder()->toSql();
        $this->assertStringContainsString('select *', $sql);
    }
}
