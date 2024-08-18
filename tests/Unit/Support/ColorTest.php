<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Support;

use Orchid\Support\Color;
use Orchid\Tests\TestUnitCase;

class ColorTest extends TestUnitCase
{
    /**
     * Test that the `name` method returns the correct string for each color case.
     */
    public function testNameMethod(): void
    {
        $this->assertEquals('info', Color::INFO->name());
        $this->assertEquals('success', Color::SUCCESS->name());
        $this->assertEquals('warning', Color::WARNING->name());
        $this->assertEquals('default', Color::BASIC->name());
        $this->assertEquals('default', Color::DEFAULT->name());
        $this->assertEquals('danger', Color::DANGER->name());
        $this->assertEquals('danger', Color::ERROR->name());
        $this->assertEquals('primary', Color::PRIMARY->name());
        $this->assertEquals('secondary', Color::SECONDARY->name());
        $this->assertEquals('light', Color::LIGHT->name());
        $this->assertEquals('dark', Color::DARK->name());
        $this->assertEquals('link', Color::LINK->name());
    }

    /**
     * Test that the dynamically generated methods return the correct color case for each name.
     * It is used to maintain backwards compatibility to 13.0.
     */
    public function testDynamicColorMethods(): void
    {
        $this->assertEquals(Color::INFO, Color::INFO());
        $this->assertEquals(Color::SUCCESS, Color::SUCCESS());
        $this->assertEquals(Color::WARNING, Color::WARNING());
        $this->assertEquals(Color::BASIC, Color::BASIC());
        $this->assertEquals(Color::DEFAULT, Color::DEFAULT());
        $this->assertEquals(Color::DANGER, Color::DANGER());
        $this->assertEquals(Color::PRIMARY, Color::PRIMARY());
        $this->assertEquals(Color::SECONDARY, Color::SECONDARY());
        $this->assertEquals(Color::LIGHT, Color::LIGHT());
        $this->assertEquals(Color::DARK, Color::DARK());
        $this->assertEquals(Color::LINK, Color::LINK());
    }
}
