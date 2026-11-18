<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Illuminate\Contracts\View\View;
use Orchid\Screen\LayoutFactory;
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

        $layout = LayoutFactory::wrapper('exemplar::layouts.wrapper', []);

        $view = $layout->build($repository);

        $data = $view->getData();
        $html = $view->render();

        $this->assertTrue($data['variable']);
        $this->assertStringContainsString('<p>Hello Alexandr Chernyaev</p>', $html);
    }

    public function testDataVariables(): void
    {
        $repository = new Repository;

        $layout = LayoutFactory::wrapper('exemplar::layouts.wrapper', [
            'variable1' => [
                LayoutFactory::rows([]),
                LayoutFactory::rows([]),
                LayoutFactory::rows([]),
            ],
            'variable2' => LayoutFactory::rows([]),
        ]);

        $view = $layout->build($repository);
        $data = $view->getData();

        $this->assertIsArray($data['variable1']);
        $this->assertCount(3, $data['variable1']);

        $this->assertContainsOnlyInstancesOf(View::class, $data['variable1']);
        $this->assertInstanceOf(View::class, $data['variable2']);
    }
}
