<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Database\Seeders\AttachmentsTableSeeder;
use Orchid\Platform\Database\Seeders\RolesTableSeeder;
use Orchid\Platform\Database\Seeders\UsersTableSeeder;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

class SeedersTest extends TestUnitCase
{
    public function testUsersSeederCreatesTenUsers(): void
    {
        $count = User::count();

        (new UsersTableSeeder)->run();

        $this->assertSame($count + 10, User::count());
    }

    public function testRolesSeederCreatesFiveRoles(): void
    {
        $count = Role::count();

        (new RolesTableSeeder)->run();

        $this->assertSame($count + 5, Role::count());
    }

    public function testAttachmentsSeederStoresImagesOnItsConfiguredDisk(): void
    {
        Storage::fake('seeded');
        $seeder = new AttachmentsTableSeeder;
        $seeder->storage = 'seeded';
        $seeder->filecounts = 2;

        $seeder->run();

        $attachments = Attachment::where('disk', 'seeded')->get();
        $this->assertCount(2, $attachments);

        foreach ($attachments as $attachment) {
            Storage::disk('seeded')->assertExists($attachment->physicalPath());
            $image = getimagesizefromstring(Storage::disk('seeded')->get($attachment->physicalPath()));

            $this->assertSame([640, 480], [$image[0], $image[1]]);
            $this->assertSame('attachment.jpg', $attachment->original_name);
        }
    }
}
