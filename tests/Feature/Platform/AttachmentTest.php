<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Illuminate\Http\UploadedFile;
use Orchid\Tests\TestFeatureCase;

class AttachmentTest extends TestFeatureCase
{
    /**
     * @var User
     */
    private $user;

    public function testAttachmentHttpUpload()
    {
        $response = $this
            ->actingAs($this->getUser())
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

    private function getUser()
    {
        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();

        return $this->user;
    }

    public function testAttachmentHttpMultiUpload()
    {
        $response = $this
            ->actingAs($this->getUser())
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
            ->actingAs($this->getUser())
            ->post(route('platform.systems.files.upload'), [
                'files' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        /** @var $upload \Orchid\Attachment\Models\Attachment */
        $upload = $response->original;

        $response = $this
            ->actingAs($this->getUser())
            ->delete(route('platform.systems.files.destroy', $upload->id));

        $response->assertOk();
    }

    public function testAttachmentHttpGetFile()
    {
        /** @var $response \Illuminate\Foundation\Testing\TestResponse */
        $response = $this
            ->actingAs($this->getUser())
            ->post(route('platform.systems.files.upload'), [
                'files' => UploadedFile::fake()->image('testAttachmentHttpGetFile.jpg'),
            ]);

        /** @var $upload \Orchid\Attachment\Models\Attachment */
        $upload = $response->original;

        $response = $this
            ->actingAs($this->getUser())
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
            ->actingAs($this->getUser())
            ->post(route('platform.systems.files.upload'), [
                'files' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        /** @var $upload \Orchid\Attachment\Models\Attachment */
        $upload = $response->original;

        $response = $this
            ->actingAs($this->getUser())
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
