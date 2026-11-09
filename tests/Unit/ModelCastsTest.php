<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Carbon;
use Orchid\Access\Permissions;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

class ModelCastsTest extends TestUnitCase
{
    public function testUserSubclassCanExtendInheritedCasts(): void
    {
        $user = new class extends User
        {
            protected function casts(): array
            {
                return [...parent::casts(), 'settings' => 'array'];
            }
        };

        $user->permissions = ['platform.index' => true];
        $user->email_verified_at = '2026-01-01 12:00:00';
        $user->setAttribute('settings', ['theme' => 'dark']);

        $this->assertInstanceOf(Permissions::class, $user->permissions);
        $this->assertTrue($user->permissions->allows('platform.index'));
        $this->assertInstanceOf(Carbon::class, $user->email_verified_at);
        $this->assertSame(['theme' => 'dark'], $user->getAttribute('settings'));
    }

    public function testUserSubclassCanOverrideInheritedCasts(): void
    {
        $user = new class extends User
        {
            protected function casts(): array
            {
                return [...parent::casts(), 'permissions' => 'array'];
            }
        };

        $user->permissions = ['platform.index' => true];
        $user->email_verified_at = '2026-01-01 12:00:00';

        $this->assertSame(['platform.index' => true], $user->permissions);
        $this->assertInstanceOf(Carbon::class, $user->email_verified_at);
    }

    public function testRoleSubclassInheritsPermissionCast(): void
    {
        $role = new class extends Role {};
        $role->permissions = ['platform.index' => true];

        $this->assertInstanceOf(Permissions::class, $role->permissions);
        $this->assertTrue($role->permissions->allows('platform.index'));
    }

    public function testAttachmentSubclassInheritsSortCast(): void
    {
        $attachment = new class extends Attachment {};
        $attachment->sort = '12';

        $this->assertSame(12, $attachment->sort);
    }
}
