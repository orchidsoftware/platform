<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Support;

use Orchid\Support\Blade;
use Orchid\Tests\App\Components\ClosureComponent;
use Orchid\Tests\App\Components\EmptyComponent;
use Orchid\Tests\App\Components\Hello;
use Orchid\Tests\App\Components\HtmlableComponent;
use Orchid\Tests\TestUnitCase;

class BladeComponentTest extends TestUnitCase
{
    public function testEmptyComponent(): void
    {
        $view = Blade::renderComponent(EmptyComponent::class, []);

        $this->assertEmpty($view);
    }

    public function testHelloComponent(): void
    {
        $view = Blade::renderComponent(Hello::class, [
            'name' => 'Alexandr',
        ]);

        $this->assertStringContainsString('Hello Alexandr', $view);
        $this->assertStringContainsString(app()->version(), $view);
    }

    public function testHelloClosure(): void
    {
        $view = Blade::renderComponent(ClosureComponent::class, [
            'name' => 'Alexandr',
        ]);

        $this->assertStringContainsString('Hello Alexandr', $view);
    }

    public function testHelloHtmlable(): void
    {
        $view = Blade::renderComponent(HtmlableComponent::class, []);

        $this->assertStringContainsString('Hello word', $view);
    }

    public function testAnonymous(): void
    {
        $view = Blade::renderComponent('exemplar::simple-anonymous-component', [
            'property1' => 'Hello world',
        ]);

        $this->assertStringContainsString('Hello world', $view);
    }
}
