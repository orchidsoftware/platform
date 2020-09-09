<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Http\UploadedFile;
use Orchid\Attachment\Models\Attachment;
use Orchid\Tests\TestFeatureCase;

class AttachmentTest extends TestFeatureCase
{
    public function testAttachmentHttpUpload(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.files.upload'), [
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

    public function testAttachmentHttpMultiUpload(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.files.upload'), [
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
        /** @var $response \Illuminate\Testing\TestResponse */
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.files.upload'), [
                'files' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        /** @var $upload \Orchid\Attachment\Models\Attachment */
        $upload = $response->original;

        $response = $this
            ->actingAs($this->createAdminUser())
            ->delete(route('platform.systems.files.destroy', $upload->id));

        $response->assertOk();
    }

    public function testAttachmentHttpGetFile(): void
    {
        /** @var $response \Illuminate\Testing\TestResponse */
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.files.upload'), [
                'files' => UploadedFile::fake()->image('testAttachmentHttpGetFile.jpg'),
            ]);

        /** @var $upload \Orchid\Attachment\Models\Attachment */
        $upload = $response->original;

        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.files.getFilesByIds', [
                'files' => $upload->id,
            ]));

        $response->assertOk();
        /*TODO

            ->assertJson([
                'id' => $upload->id,
            ]);
        */
    }

    public function testAttachmentHttpUpdate(): void
    {
        /** @var $response \Illuminate\Testing\TestResponse */
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.files.upload'), [
                'files' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        /** @var $upload \Orchid\Attachment\Models\Attachment */
        $upload = $response->original;

        $response = $this
            ->actingAs($this->createAdminUser())
            ->put(route('platform.systems.files.update', $upload->id), [
                'name'        => 'New name',
                'description' => 'New description',
                'alt'         => 'New alt',
            ]);

        $response
            ->assertOk()
            ->assertJson([
                'name'        => 'New name',
                'description' => 'New description',
                'alt'         => 'New alt',
            ]);
    }

    public function testAttachmentHttpSort(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.files.upload'), [
                'files' => [
                    UploadedFile::fake()->image('first.jpg'),
                    UploadedFile::fake()->image('second.png'),
                ],
            ]);

        $attachments = $response->decodeResponseJson()->json();

        $originalFiles = [];
        $files = [];

        foreach ($attachments as $attachment) {
            $files[] = $originalFiles[] = $attachment['id'];
        }

        arsort($originalFiles);
        $sort = array_flip($files);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.files.sort'), [
                'files' => $sort,
            ]);

        $response->isOk();

        $attachments = Attachment::whereIn('id', $originalFiles)
            ->pluck('sort', 'id')
            ->toArray();

        $this->assertEquals($sort, $attachments);
    }
}
