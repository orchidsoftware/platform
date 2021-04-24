<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Init;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class UploadTest extends TestFieldsUnitCase
{
    public function testStorage(): void
    {
        $upload = Upload::make('file');
        $this->assertSame('public', $upload->getAttributes()['visibility']);

        $upload = Upload::make('file')->storage('local');
        $this->assertNull($upload->getAttributes()['visibility']);
    }

    public function testExceedMaxServerSize()
    {
        $uploadSize = Init::maxFileUpload(Init::MB) + 1;
        $upload = Upload::make('file')->maxFileSize($uploadSize);

        $this->expectException(\RuntimeException::class);
        $upload->render();
    }

    public function testNonDivisionGroup(): void
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

    public function testDivisionGroup(): void
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
}
