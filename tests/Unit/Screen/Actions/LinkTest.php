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
    public function test_link_instance(): void
    {
        $link = Link::make('About');
        $view = self::renderField($link);

        $this->assertStringContainsString('About', $view);
        $this->assertStringContainsString('href="#!"', $view);
        $this->assertStringContainsString('data-turbo="true"', $view);
    }

    public function test_link_target(): void
    {
        $link = Link::make('About')
            ->target('_blank');

        $view = self::renderField($link);

        $this->assertStringContainsString('target="_blank"', $view);
    }

    public function test_link_download(): void
    {
        $link = Link::make('About')
            ->download();

        $view = self::renderField($link);

        $this->assertStringContainsString('download', $view);
    }

    public function test_link_title(): void
    {
        $link = Link::make('About')
            ->title('Please click to download the file.')
            ->download();

        $view = self::renderField($link);

        $this->assertStringContainsString('Please click to download the file.', $view);
    }

    public function test_link_href(): void
    {
        $link = Link::make('About')
            ->href('https://google.com');

        $view = self::renderField($link);

        $this->assertStringContainsString('href="https://google.com"', $view);
    }

    public function test_link_disable_turbolinks(): void
    {
        $link = Link::make('About')
            ->href('https://google.com')
            ->rawClick();

        $view = self::renderField($link);

        $this->assertStringContainsString('data-turbo="false"', $view);
    }
}
