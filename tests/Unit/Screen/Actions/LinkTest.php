<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Actions\Link;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class LinkTest.
 */
class LinkTest extends TestFieldsUnitCase
{
    /**
     * @test
     */
    public function testLinkInstance()
    {
        $link = Link::make('About');
        $view = self::renderField($link);

        $this->assertStringContainsString('About', $view);
        $this->assertStringContainsString('href="#!"', $view);
        $this->assertStringContainsString('data-turbolinks="true"', $view);
    }

    /**
     * @test
     */
    public function testLinkTarget()
    {
        $link = Link::make('About')
            ->target('_blank');

        $view = self::renderField($link);

        $this->assertStringContainsString('target="_blank"', $view);
    }

    /**
     * @test
     */
    public function testLinkDownload()
    {
        $link = Link::make('About')
            ->download();

        $view = self::renderField($link);

        $this->assertStringContainsString('download', $view);
    }

    /**
     * @test
     */
    public function testLinkTitle()
    {
        $link = Link::make('About')
            ->title('Please click to download the file.')
            ->download();

        $view = self::renderField($link);

        $this->assertStringContainsString('Please click to download the file.', $view);
    }

    /**
     * @test
     */
    public function testLinkHref()
    {
        $link = Link::make('About')
            ->href('https://google.com');

        $view = self::renderField($link);

        $this->assertStringContainsString('href="https://google.com"', $view);
    }

    /**
     * @test
     */
    public function testLinkDisableTurbolinks()
    {
        $link = Link::make('About')
            ->href('https://google.com')
            ->rawClick();

        $view = self::renderField($link);

        $this->assertStringContainsString('data-turbolinks="false"', $view);
    }
}
