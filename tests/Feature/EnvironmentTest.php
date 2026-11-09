<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;
use PHPUnit\Framework\Attributes\DataProvider;

class EnvironmentTest extends TestFeatureCase
{
    public static function isolatedRuns(): array
    {
        return [['first'], ['second']];
    }

    #[DataProvider('isolatedRuns')]
    public function testDatabaseStartsEmpty(string $run): void
    {
        $this->assertDatabaseCount('users', 0);

        User::factory()->create(['name' => $run]);

        $this->assertDatabaseCount('users', 1);
    }

    public function testHomeRedirectsToDashboard(): void
    {
        $this->get('/')->assertRedirect(route('orchid.index'));
    }

    public function testDatabaseEnforcesForeignKeys(): void
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('FOREIGN KEY constraint failed');

        DB::table('role_users')->insert([
            'user_id' => 999,
            'role_id' => 'missing-role',
        ]);
    }
}
