<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Orchid\Attachment\Models\Attachment;
use Orchid\Tests\App\Policies\PolicySortAllow;
use Orchid\Tests\App\Policies\PolicySortDeny;
use Orchid\Tests\App\Policies\PolicySortWithoutMethod;
use Orchid\Tests\TestFeatureCase;

class SortableTest extends TestFeatureCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Gate::policy(Attachment::class, PolicySortAllow::class);
    }

    protected function tearDown(): void
    {
        Gate::policy(Attachment::class, null);
        parent::tearDown();
    }

    public function testSortingIsForbiddenWhenPolicyDenies(): void
    {
        Gate::policy(Attachment::class, PolicySortDeny::class);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => [
                    UploadedFile::fake()->image('first.jpg'),
                    UploadedFile::fake()->image('second.png'),
                ],
            ]);

        $attachments = $response->decodeResponseJson()->json();

        $ids = array_column($attachments, 'id');
        $sortBefore = Attachment::whereIn('id', $ids)->pluck('sort', 'id')->toArray();

        $sortItems = collect($ids)->map(fn ($id, $index) => [
            'id'        => $id,
            'sortOrder' => $index,
        ])->values()->all();

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.sorting'), [
                'items' => $sortItems,
                'model' => Attachment::class,
            ]);

        $response->assertForbidden();

        $sortAfter = Attachment::whereIn('id', $ids)->pluck('sort', 'id')->toArray();
        $this->assertSame($sortBefore, $sortAfter, 'Sort order must not change when policy denies.');
    }

    public function testSortingIsAllowedWhenPolicyIsMissing(): void
    {
        Gate::policy(Attachment::class, null);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => [
                    UploadedFile::fake()->image('first.jpg'),
                    UploadedFile::fake()->image('second.png'),
                ],
            ]);

        $attachments = $response->decodeResponseJson()->json();

        $ids = array_column($attachments, 'id');
        $sortItems = collect($ids)->reverse()->values()->map(fn ($id, $index) => [
            'id'        => $id,
            'sortOrder' => $index,
        ])->all();

        $expectedSort = collect($sortItems)->pluck('sortOrder', 'id')->all();

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.sorting'), [
                'items' => $sortItems,
                'model' => Attachment::class,
            ]);

        $response->assertOk();

        $sortAfter = Attachment::whereIn('id', $ids)->pluck('sort', 'id')->toArray();

        ksort($expectedSort);
        ksort($sortAfter);

        $this->assertSame($expectedSort, $sortAfter, 'Sort order should change when policy is missing.');
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
            ->post(route('orchid.sorting'), [
                'items' => $sortItems,
                'model' => Attachment::class,
            ]);

        $response->assertOk();

        $attachments = Attachment::whereIn('id', $originalFiles)
            ->pluck('sort', 'id')
            ->toArray();

        $this->assertEquals($sort, $attachments);
    }

    public function testSortingIsAllowedWhenPolicyHasNoIsSortableMethod(): void
    {
        Gate::policy(Attachment::class, PolicySortWithoutMethod::class);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.files.upload'), [
                'files' => [
                    UploadedFile::fake()->image('first.jpg'),
                    UploadedFile::fake()->image('second.png'),
                ],
            ]);

        $attachments = $response->decodeResponseJson()->json();

        $ids = array_column($attachments, 'id');
        $sortItems = collect($ids)->reverse()->values()->map(fn ($id, $index) => [
            'id'        => $id,
            'sortOrder' => $index,
        ])->all();

        $expectedSort = collect($sortItems)->pluck('sortOrder', 'id')->all();

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.sorting'), [
                'items' => $sortItems,
                'model' => Attachment::class,
            ]);

        $response->assertOk();

        $sortAfter = Attachment::whereIn('id', $ids)->pluck('sort', 'id')->toArray();

        ksort($expectedSort);
        ksort($sortAfter);

        $this->assertSame($expectedSort, $sortAfter, 'Sort order should change when policy has no isSortable method.');
    }
}
