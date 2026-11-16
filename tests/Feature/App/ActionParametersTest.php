<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\App\Screens\ActionParametersScreen;
use Orchid\Tests\App\Screens\ModelRouteBindScreen;
use Orchid\Tests\TestFeatureCase;

class ActionParametersTest extends TestFeatureCase
{
    public function testQueryStringCannotOverridePathModel(): void
    {
        Route::screen('action-user/{user}', ModelRouteBindScreen::class)
            ->middleware(config('orchid.middleware.private'))->name('action-user');
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user)->get(route('action-user', $user).'?user='.$other->id)
            ->assertOk()->assertSee($user->email)->assertDontSee($other->email);
    }

    public function testActionArgumentsDoNotMutateTheRequestRoute(): void
    {
        Route::screen('actions', ActionParametersScreen::class)->name('actions');
        $user = User::factory()->create();

        $this->post(route('actions', ['method' => 'select']).'?user=999', [
            '_parameters' => json_encode(['user' => $user->id]),
        ])->assertOk()->assertJson([
            'selected'   => $user->id,
            'route_user' => null,
            'action'     => ActionParametersScreen::class,
        ]);
    }

    public function testPathParametersTakePrecedenceOverActionArguments(): void
    {
        Route::screen('actions/{user}', ActionParametersScreen::class)->name('actions');
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->post(route('actions', ['user' => $user, 'method' => 'select']), [
            '_parameters' => json_encode(['user' => $other->id]),
        ])->assertOk()->assertJson(['selected' => $user->id]);
    }

    public function testUnknownModelReturnsNotFound(): void
    {
        Route::screen('actions', ActionParametersScreen::class)->name('actions');

        $this->postJson(route('actions', ['method' => 'select']), [
            '_parameters' => json_encode(['user' => 999]),
        ])->assertNotFound();
    }

    public function testScopedBindingsRejectModelsOutsideTheParent(): void
    {
        Route::screen('scoped/{user}/{role}', ActionParametersScreen::class)
            ->scopeBindings()->name('scoped');
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $other = Role::factory()->create();
        $user->roles()->attach($role);

        $this->post(route('scoped', ['user' => $user, 'role' => $role, 'method' => 'selectRole']))
            ->assertOk()->assertJson(['user' => $user->id, 'role' => $role->id]);
        $this->post(route('scoped', ['user' => $user, 'role' => $other, 'method' => 'selectRole']))
            ->assertNotFound();
    }

    public function testInvalidActionArgumentsAreRejected(): void
    {
        Route::screen('actions', ActionParametersScreen::class)->name('actions');

        foreach (['invalid', 'null', 'true', '"scalar"'] as $parameters) {
            $this->postJson(route('actions', ['method' => 'select']), [
                '_parameters' => $parameters,
            ])->assertUnprocessable();
        }
    }

    public function testDeferredModalReceivesModelAndScreenState(): void
    {
        $user = $this->createAdminUser();
        $screen = new ActionParametersScreen;
        $state = (object) ['marker' => 'Preserved state'];
        $slug = Layout::modal('edit', [])->getSlug();

        $this->actingAs($user)->postJson(route('orchid.async').'?user=999', [
            '_screen'     => Crypt::encryptString($screen::class),
            '_call'       => 'loadUser',
            '_template'   => $slug,
            '_state'      => Crypt::encrypt($state),
            '_parameters' => json_encode(['user' => $user->id, 'state' => ['marker' => 'Untrusted state']]),
        ])->assertOk()->assertSee($user->name)->assertSee('Preserved state');
    }
}
