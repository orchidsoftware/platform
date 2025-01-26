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
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class AttachmentTest.
 */
class AttachmentTest extends TestUnitCase
{
    /**
     * @var string
     */
    protected $disk;

    /**
     * @var string
     */
    protected $path;

    protected function setUp(): void
    {
        parent::setUp();
        $this->disk = 'public';
        $this->path = '/test';
    }

    public function test_attachment_file(): void
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

    public function test_attachment_custom_engine_file(): void
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

    public function test_attachment_custom_path(): void
    {
        $file = UploadedFile::fake()->create('document.xml', 200);
        $attachment = new File($file, $this->disk);

        /** @var Attachment $upload */
        $upload = $attachment->path($this->path)->load();

        $this->assertEquals([
            'size' => $file->getSize(),
            'name' => $file->name,
        ], [
            'size' => $upload->size,
            'name' => $upload->original_name,
        ]);

        $this->assertTrue(Storage::disk($this->disk)->exists($upload->physicalPath()));

        $path = $this->path.'/'.$upload->name.'.xml';

        $this->assertStringContainsString($path, $upload->physicalPath());
        $this->assertStringContainsString($path, $upload->url());
    }

    public function test_attachment_image(): void
    {
        $file = UploadedFile::fake()->image('avatar.jpg', 1920, 1080)->size(100);

        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertNotNull($upload->url());
    }

    public function test_attachment_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $file = UploadedFile::fake()->create('user.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertEquals($upload->user()->first()->email, $user->email);
    }

    public function test_attachment_url_link(): void
    {
        $file = UploadedFile::fake()->create('example.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertNotNull($upload->getUrlAttribute());
        $this->assertNotNull($upload->url());
    }

    public function test_attachment_url_link_not_found(): void
    {
        $upload = new Attachment;

        $this->assertNull($upload->url());
        $this->assertEquals('default', $upload->url('default'));
    }

    public function test_attachment_mime_type(): void
    {
        $file = UploadedFile::fake()->create('user.jpg', 1920, 1080);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertEquals('image/jpeg', $upload->getMimeType());
    }

    public function test_attachment_delete(): void
    {
        $file = UploadedFile::fake()->create('delete.jpg');
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $delete = $upload->delete();

        $this->assertTrue($delete);
    }

    public function test_duplicate_attachment_upload(): void
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

    public function test_attachment_upload_allowing_duplicate(): void
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

    public function test_unknown_mime_type_attachment_upload(): void
    {
        $file = UploadedFile::fake()->create('duplicate.gyhkjfewfowejg');
        $upload = (new File($file, $this->disk))->load();

        $this->assertEquals('unknown', $upload->getMimeType());
    }

    public function test_unknown_extension_attachment_upload(): void
    {
        $file = UploadedFile::fake()->create('unknown-file');
        $upload = (new File($file, $this->disk))->load();

        $this->assertEquals('bin', $upload->extension);
    }

    public function test_attachment_title_attribute(): void
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

    public function test_attachment_trait(): void
    {
        $file = UploadedFile::fake()->create('relations');
        $upload = (new File($file, $this->disk))->load();

        $model = new class extends Model
        {
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

    public function test_is_mime_attachment()
    {
        $file = UploadedFile::fake()->create('is-mime.jpg');
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertTrue($upload->isMime('image/jpeg'));
        $this->assertFalse($upload->isMime('image/png'));
    }

    public function test_is_physical_exist_attachment()
    {
        $file = UploadedFile::fake()->create('isPhysical.jpg');
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertTrue($upload->isPhysicalExists());

        $attachment = new Attachment([
            'original_name' => 'photo.jpg',
            'name'          => 'random',
            'extension'     => 'jpg',
            'disk'          => 'public',
            'path'          => '2023/02/',
        ]);

        $this->assertFalse($attachment->isPhysicalExists());
    }

    public function test_download_attachment()
    {
        $file = UploadedFile::fake()->create('download.jpg');
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertTrue($upload->download() instanceof StreamedResponse);
    }
}
