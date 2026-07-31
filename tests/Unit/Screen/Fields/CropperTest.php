<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Screen\Fields\Cropper;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

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

        $this->assertStringContainsString(sprintf('value="%s"', $upload->id), $view);
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

    public function testMinWidth(): void
    {
        $picture = Cropper::make('picture')
            ->minWidth(100);

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-min-width="100"', $view);
    }

    public function testMinHeight(): void
    {
        $picture = Cropper::make('picture')
            ->minHeight(200);

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-min-height="200"', $view);
    }

    public function testMaxWidth(): void
    {
        $picture = Cropper::make('picture')
            ->maxWidth(3000);

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-max-width="3000"', $view);
    }

    public function testMaxHeight(): void
    {
        $picture = Cropper::make('picture')
            ->maxHeight(4000);

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-max-height="4000"', $view);
    }

    public function testMinCanvas(): void
    {
        $picture = Cropper::make('picture')
            ->minCanvas(50);

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-min-width="50"', $view);
        $this->assertStringContainsString('data-cropper-min-height="50"', $view);
    }

    public function testMaxCanvas(): void
    {
        $picture = Cropper::make('picture')
            ->maxCanvas(500);

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-max-width="500"', $view);
        $this->assertStringContainsString('data-cropper-max-height="500"', $view);
    }

    public function testImageSmoothingEnabled(): void
    {
        $picture = Cropper::make('picture')
            ->imageSmoothingEnabled(false);

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-image-smoothing-enabled="', $view);
    }

    public function testImageSmoothingQuality(): void
    {
        $picture = Cropper::make('picture')
            ->imageSmoothingQuality('high');

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-image-smoothing-quality="high"', $view);
    }

    public function testFillColor(): void
    {
        $picture = Cropper::make('picture')
            ->fillColor('#ff0000');

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-cropper-fill-color="#ff0000"', $view);
    }

    public function testStaticBackdrop(): void
    {
        $picture = Cropper::make('picture')
            ->staticBackdrop(true);

        $view = self::renderField($picture);

        $this->assertStringContainsString('data-bs-backdrop=static', $view);
    }
}
