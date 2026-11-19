<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Events\UploadFileEvent;
use Orchid\Platform\Http\Middleware\Access;
use Orchid\Tests\TestFeatureCase;

class AttachmentTest extends TestFeatureCase
{
    public function testGuestCannotUploadAttachment(): void
    {
        $this->assertGuest();

        $this
            ->withoutMiddleware(Access::class)
            ->post(route('orchid.files.upload'))
            ->assertForbidden();
    }

    public function testUserWithoutPermissionCannotUploadAttachment(): void
    {
        $user = $this->createAdminUser();
        $user->permissions = [];
        $user->save();

        $this
            ->actingAs($user)
            ->withoutMiddleware(Access::class)
            ->post(route('orchid.files.upload'))
            ->assertForbidden();
    }

    public function testAttachmentHttpUpload(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        $response
            ->assertOk()
            ->assertJson([
                'original_name' => 'avatar.jpg',
                'disk'          => 'public',
                'group'         => null,
            ]);
    }

    public function testFailedWriteDoesNotRecordAnUpload(): void
    {
        Event::fake([UploadFileEvent::class]);
        $disk = $this->createStub(FilesystemAdapter::class);
        $disk->method('putFileAs')->willReturn(false);
        Storage::set('public', $disk);

        $this->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => UploadedFile::fake()->create('document.txt'),
            ])
            ->assertInternalServerError();

        $this->assertDatabaseEmpty('attachments');
        Event::assertNotDispatched(UploadFileEvent::class);
    }

    public function testAttachmentHttpMultiUpload(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => [
                    UploadedFile::fake()->image('avatar1.jpg'),
                    UploadedFile::fake()->image('avatar2.png'),
                ],
            ]);

        $response
            ->assertOk()
            ->assertJson([
                [
                    'original_name' => 'avatar1.jpg',
                ],
                [
                    'original_name' => 'avatar2.png',
                ],
            ]);
    }

    public function testAttachmentHttpDestroy(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        /** @var Attachment $upload */
        $upload = $response->original;

        $response = $this
            ->actingAs($this->createAdminUser())
            ->delete(route('orchid.files.destroy', $upload->id));

        $response->assertOk();
    }

    public function testAttachmentHttpUpdate(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        /** @var Attachment $upload */
        $upload = $response->original;

        $response = $this
            ->actingAs($this->createAdminUser())
            ->put(route('orchid.files.update', $upload->id), [
                'name' => 'New name',
            ]);

        $response
            ->assertOk()
            ->assertJson([
                'name' => 'New name',
            ]);
    }

    public function testAttachmentHttpSort(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => [
                    UploadedFile::fake()->image('first.jpg'),
                    UploadedFile::fake()->image('second.png'),
                ],
            ]);

        $attachments = $response->json();

        $originalFiles = [];
        $files = [];

        foreach ($attachments as $attachment) {
            $files[] = $originalFiles[] = $attachment['id'];
        }

        arsort($originalFiles);
        $sort = array_flip($files);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.sort'), [
                'files' => $sort,
            ]);

        $response->isOk();

        $attachments = Attachment::whereIn('id', $originalFiles)
            ->pluck('sort', 'id')
            ->toArray();

        $this->assertEquals($sort, $attachments);
    }
}
