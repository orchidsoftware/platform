<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Fields;

use Orchid\Attachment\File;
use Illuminate\Http\UploadedFile;
use Orchid\Screen\Fields\Picture;

/**
 * Class PictureTest.
 */
class PictureTest extends TestFieldsUnitCase
{
    /**
     * @test
     */
    public function testInstanse()
    {
        $picture = Picture::make('picture')
                ->width(1920)
                ->height(1020)
                ->value('https://example.com/img.jpg');

        $view = self::renderField($picture);

        $this->assertStringContainsString('https://example.com/img.jpg', $view);
    }

    /**
     * @test
     */
    public function testValueTargetId()
    {
        $file = UploadedFile::fake()->create('document.jpg', 200);
        $attachment = new File($file);
        $upload = $attachment->load();

        $picture = Picture::make('picture')
            ->value($upload->id)
            ->width(1920)
            ->height(1020)
            ->targetId();

        $view = self::renderField($picture);

        $this->assertStringContainsString(sprintf('value="%d"', $upload->id), $view);
        $this->assertStringContainsString($upload->url, $view);
    }
}
