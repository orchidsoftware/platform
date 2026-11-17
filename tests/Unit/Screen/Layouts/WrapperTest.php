<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Illuminate\Contracts\View\View;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Wrapper;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class WrapperTest extends TestUnitCase
{
    public function testQueryVariables(): void
    {
        $repository = new Repository([
            'variable' => true,
            'name'     => 'Alexandr Chernyaev',
        ]);

        $layout = Wrapper::make('exemplar::layouts.wrapper', []);

        $view = $layout->build($repository);

        $data = $view->getData();
        $html = $view->render();

        $this->assertTrue($data['variable']);
        $this->assertStringContainsString('<p>Hello Alexandr Chernyaev</p>', $html);
    }

    public function testDataVariables(): void
    {
        $repository = new Repository;

        $layout = Wrapper::make('exemplar::layouts.wrapper', [
            'variable1' => [
                Rows::make([]),
                Rows::make([]),
                Rows::make([]),
            ],
            'variable2' => Rows::make([]),
        ]);

        $view = $layout->build($repository);
        $data = $view->getData();

        $this->assertIsArray($data);
        $this->assertIsArray($data['variable1']);
        $this->assertCount(3, $data['variable1']);

        /** @var View[] $variable1 */
        $variable1 = $data['variable1'];

        /** @var View $variable1 */
        $variable2 = $data['variable2'];

        $this->assertIsArray($variable1);

        $this->assertInstanceOf(View::class, $variable2);
        $this->assertInstanceOf(View::class, reset($variable1));
    }
}
