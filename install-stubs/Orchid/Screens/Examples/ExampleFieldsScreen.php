<?php

namespace App\Orchid\Screens\Examples;

use App\Orchid\Layouts\Examples\RowExample;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;

class ExampleFieldsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Form elements';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Sample Screen Components';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'name'  => 'Hello! We collected all the fields in one place',
            'place' => [
                'lat' => 37.181244855427394,
                'lng' => -3.6021993309259415,
            ],
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            RowExample::class,
        ];
    }
}
