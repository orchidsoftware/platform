<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Illuminate\Contracts\View\View;
use Orchid\Screen\Layouts;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class WrapperTest extends TestUnitCase
{
    /**
     *
     */
    public function testQueryVariables()
    {
        $repository = new Repository([
            'variable' => true,
            'name'     => 'Alexandr Chernyaev',
        ]);

        $layout = Layouts::wrapper('exemplar::layouts.wrapper', []);

        $view = $layout->build($repository);

        $data = $view->getData();
        $html = $view->render();


        $this->assertTrue($data['variable']);
        $this->assertStringContainsString('<p>Hello Alexandr Chernyaev</p>', $html);
    }

    /**
     *
     */
    public function testDataVariables()
    {
        $repository = new Repository();

        $layout = Layouts::wrapper('exemplar::layouts.wrapper', [
            'variable1' => [
                Layouts::rows([]),
                Layouts::rows([]),
                Layouts::rows([]),
            ],
            'variable2' => Layouts::rows([]),
        ]);

        $view = $layout->build($repository);
        $data = $view->getData();


        $this->assertIsArray($data);
        $this->assertIsArray($data['variable1']);
        $this->assertEquals(3, count($data['variable1']));


        /** @var View[] $variable1 */
        $variable1 = $data['variable1'];

        /** @var View $variable1 */
        $variable2 = $data['variable2'];


        $this->assertIsArray($variable1);

        $this->assertInstanceOf(View::class, $variable2);
        $this->assertEquals(Layouts::rows([])->template, $variable2->name());

        $this->assertInstanceOf(View::class, reset($variable1));
    }
}
