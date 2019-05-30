<?php

namespace App\Orchid\Layouts\Examples;

use Orchid\Screen\TD;
use Illuminate\Support\Str;
use Orchid\Screen\Repository;
use Orchid\Screen\Layouts\Table;

class TableExample extends Table
{
    /**
     * @var string
     */
    public $data = 'table';

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            TD::set('id', 'ID')
                ->width(150)
                ->render(function (Repository $model) {
                    // Please use view('path')
                    return "<img src='https://picsum.photos/450/200?random={$model->get('id')}'
                              alt='sample'
                              class='mw-100 d-block img-fluid'>
                            <span class='small text-muted mt-1 mb-0'># {$model->get('id')}</span>";
                }),

            TD::set('name', 'Name')
                ->width(450)
                ->render(function (Repository $model) {
                    return Str::limit($model->get('name'), 200);
                }),

            TD::set('price', 'Price')
                ->render(function (Repository $model) {
                    return '$ '.number_format($model->get('price'), 2);
                }),

            TD::set('created_at', 'Created'),
        ];
    }
}
