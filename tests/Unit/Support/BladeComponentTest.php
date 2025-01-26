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
    public function test_empty_component(): void
    {
        $view = Blade::renderComponent(EmptyComponent::class, []);

        $this->assertEmpty($view);
    }

    public function test_hello_component(): void
    {
        $view = Blade::renderComponent(Hello::class, [
            'name' => 'Alexandr',
        ]);

        $this->assertStringContainsString('Hello Alexandr', $view);
        $this->assertStringContainsString(app()->version(), $view);
    }

    public function test_hello_closure(): void
    {
        $view = Blade::renderComponent(ClosureComponent::class, [
            'name' => 'Alexandr',
        ]);

        $this->assertStringContainsString('Hello Alexandr', $view);
    }

    public function test_hello_htmlable(): void
    {
        $view = Blade::renderComponent(HtmlableComponent::class, []);

        $this->assertStringContainsString('Hello word', $view);
    }

    public function test_anonymous(): void
    {
        $view = Blade::renderComponent('exemplar::simple-anonymous-component', [
            'property1' => 'Hello world',
        ]);

        $this->assertStringContainsString('Hello world', $view);
    }

    public function test_popover_component(): void
    {
        $view = Blade::renderComponent('orchid-popover', [
            'content' => 'Hello world',
        ]);

        $this->assertStringContainsString('data-bs-content="Hello world"', $view);
        $this->assertStringContainsString('data-bs-placement="auto"', $view);

        $view = Blade::renderComponent('orchid-popover', [
            'content'   => 'Hello world',
            'placement' => 'right',
        ]);

        $this->assertStringContainsString('data-bs-content="Hello world"', $view);
        $this->assertStringContainsString('data-bs-placement="right"', $view);
    }
}
