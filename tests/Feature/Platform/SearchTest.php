<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Tests\App\SearchUser;
use Orchid\Tests\TestFeatureCase;

class SearchTest extends TestFeatureCase
{
    use RefreshDatabase;

    public function testSearchCompactNotRecords(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.search', ['any', 'compact']))
            ->assertOk()
            ->assertSee('There are no records in this view');
    }

    public function testSearchCompact(): void
    {
        $user = SearchUser::create([
            'id'       => 1,
            'name'     => 'Alexandr Chernyaev',
            'email'    => 'admin@localhost.com',
            'password' => 'password',
        ]);

        $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.search', [$user->email, 'compact']))
            ->assertOk()
            ->assertSee($user->name);
    }

    public function testSearchPage(): void
    {
        $user = SearchUser::create([
            'id'       => 1,
            'name'     => 'Alexandr Chernyaev',
            'email'    => 'admin@localhost.com',
            'password' => 'password',
        ]);

        $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.search', $user->email))
            ->assertOk()
            ->assertSee($user->name);
    }
}
