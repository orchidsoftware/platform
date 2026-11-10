<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class PropertyAutoWriteScreen extends Screen
{
    public $publicProperty = false;
    public int $tax = 0;
    protected $protectedProperty = false;
    private $privateProperty = false;

    /**
     * Query data.
     */
    public function query(): array
    {
        return [
            'publicProperty'    => true,
            'products'          => [(object) ['price' => 100]],
            'tax'               => 20,
            'protectedProperty' => true,
            'privateProperty'   => true,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Property auto write screen';
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
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('publicProperty')->title('publicProperty')->canSee($this->publicProperty),
                Input::make('protectedProperty')->title('protectedProperty')->canSee($this->protectedProperty),
                Input::make('privateProperty')->title('privateProperty')->canSee($this->privateProperty),
            ]),
            Table::make('products', [
                TD::make('price')->render(fn (object $product) => $product->price + $this->tax),
            ]),
        ];
    }
}
