<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
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

    public function testHandlersReceiveOnlyTheirArgumentsWithoutDispatchMetadata(): void
    {
        Route::screen('actions/{user}', ActionParametersScreen::class)->name('actions');
        $user = User::factory()->create();

        $this->post(route('actions', ['user' => $user, 'method' => 'collect']), [
            '_parameters' => json_encode(['label' => 'Selected label']),
        ])->assertOk()->assertExactJson(['selected' => $user->id, 'labels' => ['Selected label']]);
    }

    public function testPathModelsTakePrecedenceOverArgumentAliases(): void
    {
        Route::screen('profiles-snake/{user_profile}', ActionParametersScreen::class)->name('user_profile');
        Route::screen('profiles-camel/{userProfile}', ActionParametersScreen::class)->name('userProfile');
        $user = User::factory()->create();
        $other = User::factory()->create();

        foreach (['user_profile', 'userProfile'] as $key) {
            $this->postJson(route($key, [$key => $user, 'method' => 'selectProfile']), [
                '_parameters' => json_encode(['userProfile' => $other->id, 'user_profile' => $other->id]),
            ])->assertOk()->assertExactJson(['selected' => $user->id]);
        }
    }

    public function testDispatchUsesTheNamedMethodParameter(): void
    {
        Route::screen('actions', ActionParametersScreen::class)->name('actions');
        Route::matched(fn ($event) => $event->route->setParameter('context', 'Additional route context'));
        $user = User::factory()->create();

        $this->post(route('actions', ['method' => 'select']), [
            '_parameters' => json_encode(['user' => $user->id]),
        ])->assertOk()->assertJson(['selected' => $user->id]);
    }

    public function testUnknownModelReturnsNotFound(): void
    {
        Route::screen('actions', ActionParametersScreen::class)->name('actions');

        $this->postJson(route('actions', ['method' => 'select']), [
            '_parameters' => json_encode(['user' => 999]),
        ])->assertNotFound();
    }

    public function testActionArgumentsResolveBackedEnums(): void
    {
        Route::screen('enum-actions', ActionParametersScreen::class)->name('enum-actions');
        $url = route('enum-actions', ['method' => 'selectRoleName']);

        $this->postJson($url, ['_parameters' => json_encode(['role_name' => 'admin'])])
            ->assertOk()->assertExactJson(['role' => 'admin']);
        $this->postJson($url, ['_parameters' => json_encode(['role_name' => 'unknown'])])
            ->assertNotFound();
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

        foreach (['invalid', 'null', 'true', '"scalar"', null, [], 42] as $parameters) {
            $this->postJson(route('actions', ['method' => 'select']), [
                '_parameters' => $parameters,
            ])->assertUnprocessable()->assertJsonValidationErrors('_parameters');
        }
    }

    public function testActionModelsAreBoundIndependentlyOfThePathParent(): void
    {
        Route::screen('scoped-action/{user}', ActionParametersScreen::class)
            ->scopeBindings()->name('scoped-action');
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $url = route('scoped-action', ['user' => $user, 'method' => 'selectRole']);

        $this->postJson($url, ['_parameters' => json_encode(['role' => $role->id])])
            ->assertOk()->assertJson(['user' => $user->id, 'role' => $role->id]);
        $this->postJson($url, ['_parameters' => json_encode(['role' => 999])])
            ->assertNotFound();
    }

    public function testActionModelsDoNotRequireAParentChildRelationship(): void
    {
        Route::screen('scoped-actions', ActionParametersScreen::class)
            ->scopeBindings()->name('scoped-actions');
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $url = route('scoped-actions', ['method' => 'selectRole']);

        $this->postJson($url, ['_parameters' => json_encode(['role' => $role->id, 'context' => 'extra', 'user' => $user->id])])
            ->assertOk()->assertJson(['user' => $user->id, 'role' => $role->id]);
    }

    public function testValidationErrorsOnlyRenderTheSubmittedDeferredModal(): void
    {
        Route::screen('action-modals', ActionParametersScreen::class)
            ->middleware(config('orchid.middleware.private'))->name('action-modals');
        $errors = (new ViewErrorBag)->put('default', new MessageBag(['user.name' => 'Name is required.']));

        $this->actingAs($this->createAdminUser())
            ->withSession(['errors' => $errors, '_old_input' => ['_modal' => 'edit', 'user' => ['name' => 'Draft']]])
            ->get(route('action-modals'))
            ->assertOk()
            ->assertSee('Selected modal content')
            ->assertSee('Draft')
            ->assertDontSee('Other modal content');
    }

    public function testUnrelatedValidationErrorsKeepDeferredModalsUnloaded(): void
    {
        Route::screen('action-modals', ActionParametersScreen::class)
            ->middleware(config('orchid.middleware.private'))->name('action-modals');
        $errors = (new ViewErrorBag)->put('default', new MessageBag(['title' => 'Title is required.']));

        $this->actingAs($this->createAdminUser())
            ->withSession(['errors' => $errors])
            ->get(route('action-modals'))
            ->assertOk()
            ->assertDontSee('Selected modal content')
            ->assertDontSee('Other modal content');
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
