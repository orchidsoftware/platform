<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Orchid\Breadcrumbs\Trail;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Breadcrumbs;
use Orchid\Tests\TestFeatureCase;

class BreadcrumbsTest extends TestFeatureCase
{
    public function testBreadcrumbsRoute(): void
    {
        Route::get('breadcrumbs-about-test', function () {
            return Breadcrumbs::render()->toJson();
        })
            ->name('breadcrumbs.about')
            ->breadcrumbs(function (Trail $trail) {
                return $trail->push('About', 'http://localhost/about');
            });

        $this->get('breadcrumbs-about-test')
            ->assertJson([
                [
                    'title' => 'About',
                    'url'   => 'http://localhost/about',
                ],
            ]);
    }

    public function testBreadcrumbsParameters(): void
    {
        $user = factory(User::class)->create();

        Route::get('breadcrumbs-about-test/{user}', function (User $user) {
            $user->save();

            return Breadcrumbs::render()->toJson();
        })
            ->middleware(SubstituteBindings::class)
            ->name('breadcrumbs.about')
            ->breadcrumbs(function (Trail $trail, User $user) {
                return $trail->push('User email', $user->email);
            });

        $this->get(\route('breadcrumbs.about', $user->id))
            ->assertJson([
                [
                    'title' => 'User email',
                    'url'   => $user->email,
                ],
            ]);
    }
}
