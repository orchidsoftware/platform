<?php

namespace Orchid\Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Attachments\File;
use Orchid\Tests\TestUnitCase;

class AttachmentTest extends TestUnitCase
{

    /** @test */
    public function testAttachmentImage()
    {
        $file = UploadedFile::fake()->image('avatar.jpg', 1920, 1080)->size(100);


        $storage = Storage::disk('public');
        $attachment = new File($file,$storage);

        $upload = $attachment->load();

        //TODO::
    }

}
