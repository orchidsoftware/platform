<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

/**
 * Class AttachmentTest.
 */
class AttachmentTest extends TestUnitCase
{
    /**
     * @var string
     */
    public $disk;

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

        $this->assertStringContainsString($upload->name.'.xml', $upload->url());
    }

    public function testAttachmentImage()
    {
        $file = UploadedFile::fake()->image('avatar.jpg', 1920, 1080)->size(100);

        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertNotNull($upload->url());
    }

    public function testAttachmentUser()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $file = UploadedFile::fake()->create('user.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertEquals($upload->user()->first()->email, $user->email);
    }

    public function testAttachmentUrlLink()
    {
        $file = UploadedFile::fake()->create('example.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertNotNull($upload->getUrlAttribute());
        $this->assertNotNull($upload->url());
    }

    public function testAttachmentUrlLinkNotFound()
    {
        $upload = new Attachment();

        $this->assertNull($upload->url());
        $this->assertEquals($upload->url('default'), 'default');
    }

    public function testAttachmentMimeType()
    {
        $file = UploadedFile::fake()->create('user.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertEquals($upload->getMimeType(), 'image/jpeg');
    }

    public function testAttachmentDelete()
    {
        $file = UploadedFile::fake()->create('delete.jpg');
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $delete = $upload->delete();

        $this->assertTrue($delete);
    }

    public function testDuplicateAttachmentUpload()
    {
        $file = UploadedFile::fake()->create('duplicate.jpg');
        $clone = clone $file;

        $upload = (new File($file, $this->disk))->load();
        $clone = (new File($clone, $this->disk))->load();

        $this->assertEquals($upload->url(), $clone->url());
        $this->assertNotEquals($upload->id, $clone->id);

        $upload->delete();
        $this->assertNotNull($clone->url());
    }

    public function testUnknownMimeTypeAttachmentUpload()
    {
        $file = UploadedFile::fake()->create('duplicate.gyhkjfewfowejg');
        $upload = (new File($file, $this->disk))->load();

        $this->assertEquals($upload->getMimeType(), 'unknown');
    }

    public function testUnknownExtensionAttachmentUpload()
    {
        $file = UploadedFile::fake()->create('unknown-file');
        $upload = (new File($file, $this->disk))->load();

        $this->assertEquals($upload->extension, 'bin');
    }

    public function testAttachmentTitleAttribute()
    {
        $attachment = new Attachment([
            'original_name' => 'photo.jpg',
            'name'          => 'random',
            'extension'     => 'jpg',
        ]);

        $this->assertEquals($attachment->original_name, $attachment->getTitleAttribute());

        $attachment->original_name = 'blob';

        $this->assertEquals($attachment->name.'.'.$attachment->extension, $attachment->getTitleAttribute());
    }

    public function testAttachmentTrait()
    {
        $file = UploadedFile::fake()->create('relations');
        $upload = (new File($file, $this->disk))->load();

        $model = new class extends Model {
            use Attachable;
        };

        $model->id = 1;
        $model->attachment()->save($upload);

        $attachment = $model->attachment()
            ->get()
            ->first();

        $this->assertEquals($attachment->id, $upload->id);

        $sql = $model->attachment()->toSql();
        $this->assertStringContainsString('order by "sort" asc', $sql);

        $sql = $model->attachment('documents')->toSql();
        $this->assertStringContainsString(' "group" = ?', $sql);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->disk = 'public';
    }
}
