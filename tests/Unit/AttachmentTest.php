<?php

namespace Orchid\Tests\Unit;

use Orchid\Tests\TestUnitCase;
use Illuminate\Http\UploadedFile;
use Orchid\Platform\Attachments\File;
use Illuminate\Support\Facades\Storage;

class AttachmentTest extends TestUnitCase
{
    /** @test */
    public function testAttachmentImage()
    {
        $file = UploadedFile::fake()->image('avatar.jpg', 1920, 1080)->size(100);

        $storage = Storage::disk('public');
        $attachment = new File($file, $storage);

        $upload = $attachment->load();

        //TODO::
    }
}
