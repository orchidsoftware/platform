<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Http\UploadedFile;
use Orchid\Tests\TestFeatureCase;

class AttachmentTest extends TestFeatureCase
{
    public function testAttachmentHttpUpload()
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

    public function testAttachmentHttpMultiUpload()
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

    public function testAttachmentHttpDestroy()
    {
        /** @var $response \Illuminate\Foundation\Testing\TestResponse */
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

    public function testAttachmentHttpGetFile()
    {
        /** @var $response \Illuminate\Foundation\Testing\TestResponse */
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

    public function testAttachmentHttpUpdate()
    {
        /** @var $response \Illuminate\Foundation\Testing\TestResponse */
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
}
