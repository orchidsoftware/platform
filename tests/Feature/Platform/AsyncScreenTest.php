<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Orchid\Tests\App\Layouts\DependentSumListener;
use Orchid\Tests\App\Screens\DependentListenerScreen;
use Orchid\Tests\TestFeatureCase;

class AsyncScreenTest extends TestFeatureCase
{
    /**
     * Test that the asynchronous dependent listener screen returns
     * the correct calculation result.
     */
    public function testAsyncDependentListenerScreen(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.async.listener', [
                'screen' => Crypt::encryptString(DependentListenerScreen::class),
                'layout' => Crypt::encryptString(DependentSumListener::class),
            ]), [
                'first'  => 2,
                'second' => 3,
            ]);

        $response->assertOk();

        $this->assertStringContainsString('value="5"', $response->getContent());
        $this->assertStringContainsString('The result of adding', $response->getContent());
    }

    /**
     * Test that an asynchronous request to a non-existing method
     * returns a 400 Bad Request status.
     */
    public function testAsyncMethodNotFoundScreen(): void
    {
        /** @var DependentSumListener $layout */
        $layout = $this->app->make(DependentSumListener::class);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.async'), [
                '_screen'   => Crypt::encryptString(DependentListenerScreen::class),
                '_call'   => Str::random(),
                '_template' => $layout->getSlug(),
            ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test that attempting to call a denied method asynchronously
     * returns a 400 Bad Request status.
     */
    public function testAsyncDeniedMethodScreen(): void
    {
        /** @var DependentSumListener $layout */
        $layout = $this->app->make(DependentSumListener::class);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.async', [
                'first'  => 2,
                'second' => 3,
            ]), [
                '_screen'   => Crypt::encryptString(DependentListenerScreen::class),
                '_call'   => 'validate',
                '_template' => $layout->getSlug(),
            ]);

        $response
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
