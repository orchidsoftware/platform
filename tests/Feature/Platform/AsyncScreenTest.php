<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\App\Layouts\DependentSumListener;
use Orchid\Tests\TestFeatureCase;

class AsyncScreenTest extends TestFeatureCase
{
    public function testAcyncDependentListenerScreen()
    {
        /** @var DependentSumListener $layout */
        $layout = $this->app->make(DependentSumListener::class);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('test.dependent-listener', [
                'method'   => $layout->getSlug(),
                'argument' => 'asyncSum',
            ]), [
                'first'  => 2,
                'second' => 3,
            ]);


        $response->assertOk();

        $this->assertStringContainsString('value="5"', $response->getContent());
        $this->assertStringContainsString('The result of adding', $response->getContent());
    }
}
