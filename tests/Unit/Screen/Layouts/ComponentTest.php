<?php

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;
use Orchid\Tests\App\Components\Hello;
use Orchid\Tests\TestUnitCase;

class ComponentTest extends TestUnitCase
{
    public function testQueryVariables(): void
    {
        $repository = new Repository([
            'name' => 'Alexandr Chernyaev',
        ]);

        $layout = LayoutFactory::component(Hello::class);

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
        $this->assertStringContainsString($this->app->version(), $html);
    }

    public function testAccessByAlias(): void
    {
        $repository = new Repository([
            'name' => 'Alexandr Chernyaev',
        ]);

        $this->app->make('blade.compiler')->component(Hello::class, 'hello-test-component');

        $layout = LayoutFactory::component('hello-test-component');

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
        $this->assertStringContainsString($this->app->version(), $html);
    }

    public function testAnonymousComponent(): void
    {
        $repository = new Repository([
            'property1' => 'First property value',
        ]);

        $layout = LayoutFactory::component('exemplar::simple-anonymous-component');

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('First property value', $html);
        $this->assertStringContainsString('default value', $html);
    }

    public function testWithAdditionalData(): void
    {
        $repository = new Repository([
            'property1' => 'First property value',
        ]);

        $layout = LayoutFactory::component('exemplar::simple-anonymous-component')->with([
            'property2' => 'It is second property value',
        ]);

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('First property value', $html);
        $this->assertStringContainsString('It is second property value', $html);
    }

    public function testAdditionalDataOverrideRepositoryData(): void
    {
        $repository = new Repository([
            'property1' => 'First property value',
        ]);

        $layout = LayoutFactory::component('exemplar::simple-anonymous-component')->with([
            'property1' => 'This value is final',
        ]);

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('This value is final', $html);
        $this->assertStringNotContainsString('First property value', $html);
    }
}
