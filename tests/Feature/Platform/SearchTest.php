<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\App\User;
use Orchid\Tests\TestFeatureCase;

class SearchTest extends TestFeatureCase
{
    public function testSearchCompactNotRecords()
    {
        $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.search', ['any', 'compact']))
            ->assertOk()
            ->assertSee('There are no records in this view');
    }

    public function testSearchCompact()
    {
        $user = User::create([
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

    public function testSearchPage()
    {
        $user = User::create([
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
