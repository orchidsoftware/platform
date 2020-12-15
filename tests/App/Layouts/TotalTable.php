<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

class TotalTable extends Table
{
    /**
     * @var string
     */
    protected $target = 'table';

    /**
     * @return array
     */
    protected function columns(): array
    {
        return [
            TD::set('id'),
            TD::set('price'),
            TD::set('tax'),
        ];
    }

    /**
     * @return array
     */
    public function total(): array
    {
        return [
            TD::set('total')
                ->align(TD::ALIGN_RIGHT)
                ->colspan(2)
                ->render(function () {
                    return 'Total:';
                }),

            TD::set('total_price')
                ->align(TD::ALIGN_RIGHT),
        ];
    }

    /**
     * @return Repository
     */
    public static function getData(): Repository
    {
        return new Repository([
            'table' => [
                new Repository(['id' => 100, 'price' => 10.24, 'tax' => 0.13]),
                new Repository(['id' => 200, 'price' => 65.9, 'tax' => 0.13]),
                new Repository(['id' => 300, 'price' => 754.2, 'tax' => 0.13]),
                new Repository(['id' => 400, 'price' => 0.1, 'tax' => 0.13]),
                new Repository(['id' => 500, 'price' => 0.15, 'tax' => 0.13]),
            ],
            'total_price' => 600,
            'total_tax' => 0.2,
        ]);
    }
}
