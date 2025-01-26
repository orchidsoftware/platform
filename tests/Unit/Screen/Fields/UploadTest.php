<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Init;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class UploadTest extends TestFieldsUnitCase
{
    public function test_storage(): void
    {
        $upload = Upload::make('file');
        $this->assertSame('public', $upload->getAttributes()['visibility']);

        $upload = Upload::make('file')->storage('local');
        $this->assertNull($upload->getAttributes()['visibility']);
    }

    public function test_exceed_max_server_size()
    {
        $uploadSize = Init::maxFileUpload(Init::MB) + 1;
        $upload = Upload::make('file')->maxFileSize($uploadSize);

        $this->expectException(\RuntimeException::class);
        $upload->render();
    }

    public function test_non_division_group(): void
    {
        $imagesGroup = Attachment::factory()->create(['group' => 'images']);
        $docsGroup = Attachment::factory()->create(['group' => 'docs']);

        $upload = Upload::make('file')->value([
            $docsGroup,
            $imagesGroup,
        ]);

        $view = self::renderField($upload);

        $this->assertStringContainsString($docsGroup->getTitleAttribute(), $view);
        $this->assertStringContainsString($imagesGroup->getTitleAttribute(), $view);
    }

    public function test_division_group(): void
    {
        $imagesGroup = Attachment::factory()->create(['group' => 'images']);
        $docsGroup = Attachment::factory()->create(['group' => 'docs']);

        // pass models
        $upload = Upload::make('file')
            ->groups('images')
            ->value([
                $docsGroup,
                $imagesGroup,
            ]);

        $view = self::renderField($upload);

        $this->assertStringContainsString($imagesGroup->getTitleAttribute(), $view);
        $this->assertStringNotContainsString($docsGroup->getTitleAttribute(), $view);

        // pass ids
        $upload = Upload::make('file')
            ->groups('images')
            ->value([
                $docsGroup->id,
                $imagesGroup->id,
            ]);

        $view = self::renderField($upload);

        $this->assertStringContainsString($imagesGroup->getTitleAttribute(), $view);
        $this->assertStringNotContainsString($docsGroup->getTitleAttribute(), $view);
    }

    public function test_uploaded_path(): void
    {
        $file = UploadedFile::fake()->create('document.jpg', 200);
        $path = 'custom-path';
        $attachment = new File($file);
        $upload = $attachment->path($path)->load();

        $uploader = Upload::make('file')
            ->path($path);

        $view = self::renderField($uploader);

        $this->assertStringContainsString(sprintf('data-upload-path="%s"', $path), $view);
        $this->assertSame($upload->path, $path.'/');
    }
}
