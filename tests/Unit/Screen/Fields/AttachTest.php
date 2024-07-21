<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Fields\Attach;
use Orchid\Support\Init;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class AttachTest extends TestFieldsUnitCase
{
    public function testExceedMaxServerSize(): void
    {
        $uploadSize = Init::maxFileUpload(Init::MB) + 1;
        $upload = Attach::make('file')->maxFileSize($uploadSize);

        $this->expectException(\RuntimeException::class);
        $upload->render();
    }

    public function testNonDivisionGroup(): void
    {
        $imagesGroup = Attachment::factory()->create(['group' => 'images']);
        $docsGroup = Attachment::factory()->create(['group' => 'docs']);

        $upload = Attach::make('file')->value([
            $docsGroup,
            $imagesGroup,
        ]);

        $view = self::renderField($upload);

        $this->assertStringContainsString($docsGroup->getTitleAttribute(), $view);
        $this->assertStringContainsString($imagesGroup->getTitleAttribute(), $view);
    }

    public function testDivisionGroup(): void
    {
        $imagesGroup = Attachment::factory()->create(['group' => 'images']);
        $docsGroup = Attachment::factory()->create(['group' => 'docs']);

        // pass models
        $upload = Attach::make('file')
            ->groups('images')
            ->value([
                $docsGroup,
                $imagesGroup,
            ]);

        $view = self::renderField($upload);

        $this->assertStringContainsString($imagesGroup->getTitleAttribute(), $view);
        $this->assertStringNotContainsString($docsGroup->getTitleAttribute(), $view);

        // pass ids
        $upload = Attach::make('file')
            ->groups('images')
            ->value([
                $docsGroup->id,
                $imagesGroup->id,
            ]);

        $view = self::renderField($upload);

        $this->assertStringContainsString($imagesGroup->getTitleAttribute(), $view);
        $this->assertStringNotContainsString($docsGroup->getTitleAttribute(), $view);
    }

    public function testUploadedPath(): void
    {
        $file = UploadedFile::fake()->create('document.jpg', 200);
        $path = 'custom-path';
        $attachment = new File($file);
        $upload = $attachment->path($path)->load();

        $uploader = Attach::make('file')
            ->path($path);

        $view = self::renderField($uploader);

        $this->assertStringContainsString(sprintf('data-attach-path-value="%s"', $path), $view);
        $this->assertSame($upload->path, $path . '/');
    }
}
