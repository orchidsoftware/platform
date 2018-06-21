<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Tests\TestUnitCase;
use Illuminate\Http\UploadedFile;
use Orchid\Platform\Attachments\File;

/**
 * Class AttachmentTest.
 */
class AttachmentTest extends TestUnitCase
{
    /**
     * @var string
     */
    public $disk;

    protected function setUp()
    {
        parent::setUp();
        $this->disk = 'public';
    }

    /**
     * @test
     */
    public function testAttachmentFile()
    {
        $file = UploadedFile::fake()->create('document.xml', 200);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertEquals([
            'size' => $file->getSize(),
            'name' => $file->name,
        ], [
            'size' => $upload->size,
            'name' => $upload->original_name,
        ]);

        $this->assertContains($upload->name.'.xml', $upload->url());
    }

    /**
     * @test
     */
    public function testAttachmentImage()
    {
        $file = UploadedFile::fake()->image('avatar.jpg', 1920, 1080)->size(100);

        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertContains('low', $upload->url('low'));
        $this->assertContains('medium', $upload->url('medium'));
        $this->assertContains('high', $upload->url('high'));
    }
}
