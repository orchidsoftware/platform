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
    public function testLinkInstance(): void
    {
        $link = Link::make('About');
        $view = self::renderField($link);

        $this->assertStringContainsString('About', $view);
        $this->assertStringContainsString('href="#!"', $view);
        $this->assertStringContainsString('data-turbolinks="true"', $view);
    }

    public function testLinkTarget(): void
    {
        $link = Link::make('About')
            ->target('_blank');

        $view = self::renderField($link);

        $this->assertStringContainsString('target="_blank"', $view);
    }

    public function testLinkDownload(): void
    {
        $link = Link::make('About')
            ->download();

        $view = self::renderField($link);

        $this->assertStringContainsString('download', $view);
    }

    public function testLinkTitle(): void
    {
        $link = Link::make('About')
            ->title('Please click to download the file.')
            ->download();

        $view = self::renderField($link);

        $this->assertStringContainsString('Please click to download the file.', $view);
    }

    public function testLinkHref(): void
    {
        $link = Link::make('About')
            ->href('https://google.com');

        $view = self::renderField($link);

        $this->assertStringContainsString('href="https://google.com"', $view);
    }

    public function testLinkDisableTurbolinks(): void
    {
        $link = Link::make('About')
            ->href('https://google.com')
            ->rawClick();

        $view = self::renderField($link);

        $this->assertStringContainsString('data-turbolinks="false"', $view);
    }
}
