<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Screen\Fields\Cropper;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class CropperTest.
 */
class CropperTest extends TestFieldsUnitCase
{
    public function testInstance(): void
    {
        $picture = Cropper::make('picture')
            ->width(1920)
            ->height(1020)
            ->value('https://example.com/img.jpg');

        $view = self::renderField($picture);

        $this->assertStringContainsString('https://example.com/img.jpg', $view);
    }

    public function testValueTargetId(): void
    {
        $file = UploadedFile::fake()->create('document.jpg', 200);
        $attachment = new File($file);
        $upload = $attachment->load();

        $picture = Cropper::make('picture')
            ->value($upload->id)
            ->width(1920)
            ->height(1020)
            ->targetId();

        $view = self::renderField($picture);

        $this->assertStringContainsString(sprintf('value="%d"', $upload->id), $view);
        $this->assertStringContainsString($upload->url, $view);
    }

    public function testUploadedPath(): void
    {
        $file = UploadedFile::fake()->create('document.jpg', 200);
        $path = 'custom-path';
        $attachment = new File($file);
        $upload = $attachment->path($path)->load();

        $picture = Cropper::make('picture')
            ->path($path);

        $view = self::renderField($picture);

        $this->assertStringContainsString(sprintf('data-cropper-path="%s"', $path), $view);
        $this->assertSame($upload->path, $path.'/');
    }

    public function testKeepOriginalType(): void
    {
        $picture = Cropper::make('picture')
            ->keepOriginalType();

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-keep-original-type-value="1"', $view);
    }
}
