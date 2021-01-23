<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

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
}
