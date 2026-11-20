<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use App\Orchid\Presenters\UserPresenter;
use Illuminate\Support\Str;
use LogicException;
use Orchid\Platform\Models\User;
use Orchid\Tests\App\SearchUser;
use Orchid\Tests\TestFeatureCase;

class SearchTest extends TestFeatureCase
{
    public function testUserSearchRequiresASearchableModel(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Add the Laravel Scout Searchable trait');

        (new UserPresenter(new User))->searchQuery('alex');
    }

    public function testSearchNotRecords(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.search', Str::uuid()->toString()))
            ->assertOk()
            ->assertSee('No results')
            ->assertSee('Try a different search.')
            ->assertDontSeeHtml('data-action="search#clear"')
            ->assertSee('empty-state');
    }

    public function testSearch(): void
    {
        $user = SearchUser::create([
            'id'       => 1,
            'name'     => 'Alexandr Chernyaev',
            'email'    => 'admin@localhost.com',
            'password' => 'password',
        ]);

        $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.search', $user->email))
            ->assertOk()
            ->assertSee($user->name);
    }
}
