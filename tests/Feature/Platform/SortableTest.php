<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Http\UploadedFile;
use Orchid\Attachment\Models\Attachment;
use Orchid\Tests\TestFeatureCase;

class SortableTest extends TestFeatureCase
{
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
        $sortItems = collect($sort)
            ->map(fn ($sort, $id) => ['id' => $id, 'sortOrder' => $sort])
            ->all();

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.sorting'), [
                'items' => $sortItems,
                'model' => Attachment::class,
            ]);

        $response->isOk();

        $attachments = Attachment::whereIn('id', $originalFiles)
            ->pluck('sort', 'id')
            ->toArray();

        $this->assertEquals($sort, $attachments);
    }
}
