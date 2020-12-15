<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Orchid\Tests\App\Layouts\DependentSumListener;
use Orchid\Tests\App\Screens\DependentListenerScreen;
use Orchid\Tests\TestFeatureCase;

class AsyncScreenTest extends TestFeatureCase
{
    public function testAsyncDependentListenerScreen(): void
    {
        /** @var DependentSumListener $layout */
        $layout = $this->app->make(DependentSumListener::class);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.async', [
                'screen' => Crypt::encryptString(DependentListenerScreen::class),
                'method' => 'asyncSum',
                'template' => $layout->getSlug(),
            ]), [
                'first' => 2,
                'second' => 3,
            ]);

        $response->assertOk();

        $this->assertStringContainsString('value="5"', $response->getContent());
        $this->assertStringContainsString('The result of adding', $response->getContent());
    }

    public function testAsyncMethodNotFoundScreen(): void
    {
        /** @var DependentSumListener $layout */
        $layout = $this->app->make(DependentSumListener::class);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.async', [
                'screen' => Crypt::encryptString(DependentListenerScreen::class),
                'method' => Str::random(),
                'template' => $layout->getSlug(),
            ]), [
                'first' => 2,
                'second' => 3,
            ]);

        $response->assertNotFound();
    }
}
