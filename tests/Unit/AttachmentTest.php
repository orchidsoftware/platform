<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;
use Orchid\Tests\Unit\Engine\CustomAttachmentGenerator;

/**
 * Class AttachmentTest.
 */
class AttachmentTest extends TestUnitCase
{
    /**
     * @var string
     */
    protected $disk;

    protected function setUp(): void
    {
        parent::setUp();
        $this->disk = 'public';
    }

    public function testAttachmentFile(): void
    {
        $file = UploadedFile::fake()->create('document.xml', 200);
        $attachment = new File($file, $this->disk);

        /** @var Attachment $upload */
        $upload = $attachment->load();

        $this->assertEquals([
            'size' => $file->getSize(),
            'name' => $file->name,
        ], [
            'size' => $upload->size,
            'name' => $upload->original_name,
        ]);

        $this->assertTrue(Storage::disk($this->disk)->exists($upload->physicalPath()));
        $this->assertStringContainsString($upload->name.'.xml', $upload->url());
    }

    public function testAttachmentCustomEngineFile(): void
    {
        config()->set('platform.attachment.generator', CustomAttachmentGenerator::class);
        $file = UploadedFile::fake()->create('document.xml', 200);
        $attachment = new File($file, $this->disk);

        /** @var Attachment $upload */
        $upload = $attachment->load();

        $this->assertEquals([
            'size' => $file->getSize(),
            'name' => $file->name,
        ], [
            'size' => $upload->size,
            'name' => $upload->original_name,
        ]);

        $this->assertTrue(Storage::disk($this->disk)->exists($upload->physicalPath()));

        $path = 'custom/'.$upload->name.'.xml';

        $this->assertStringContainsString($path, $upload->physicalPath());
        $this->assertStringContainsString('/storage/'.$path, $upload->url());
    }

    public function testAttachmentImage(): void
    {
        $file = UploadedFile::fake()->image('avatar.jpg', 1920, 1080)->size(100);

        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertNotNull($upload->url());
    }

    public function testAttachmentUser(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $file = UploadedFile::fake()->create('user.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertEquals($upload->user()->first()->email, $user->email);
    }

    public function testAttachmentUrlLink(): void
    {
        $file = UploadedFile::fake()->create('example.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertNotNull($upload->getUrlAttribute());
        $this->assertNotNull($upload->url());
    }

    public function testAttachmentUrlLinkNotFound(): void
    {
        $upload = new Attachment();

        $this->assertNull($upload->url());
        $this->assertEquals('default', $upload->url('default'));
    }

    public function testAttachmentMimeType(): void
    {
        $file = UploadedFile::fake()->create('user.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertEquals('image/jpeg', $upload->getMimeType());
    }

    public function testAttachmentDelete(): void
    {
        $file = UploadedFile::fake()->create('delete.jpg');
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $delete = $upload->delete();

        $this->assertTrue($delete);
    }

    public function testDuplicateAttachmentUpload(): void
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

    public function testAttachmentUploadAllowingDuplicate(): void
    {
        $file = UploadedFile::fake()->create('duplicate.jpg');
        $clone = clone $file;

        $upload = (new File($file, $this->disk))->load();
        $clone = (new File($clone, $this->disk))->allowDuplicates()->load();

        $this->assertNotEquals($upload->url(), $clone->url());
        $this->assertNotEquals($upload->id, $clone->id);

        $upload->delete();
        $this->assertNotNull($clone->url());
    }

    public function testUnknownMimeTypeAttachmentUpload(): void
    {
        $file = UploadedFile::fake()->create('duplicate.gyhkjfewfowejg');
        $upload = (new File($file, $this->disk))->load();

        $this->assertEquals('unknown', $upload->getMimeType());
    }

    public function testUnknownExtensionAttachmentUpload(): void
    {
        $file = UploadedFile::fake()->create('unknown-file');
        $upload = (new File($file, $this->disk))->load();

        $this->assertEquals('bin', $upload->extension);
    }

    public function testAttachmentTitleAttribute(): void
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

    public function testAttachmentTrait(): void
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
}
