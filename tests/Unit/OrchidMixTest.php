<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Tests\TestUnitCase;

class OrchidMixTest extends TestUnitCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! file_exists(public_path('/resources'))) {
            $this->artisan('orchid:link');
        }
    }

    public function testAssetUrl(): void
    {
        config()->set('app.asset_url', 'http://example.asset.com');

        $link = $this->getOrchidMixLink();

        $this->assertStringContainsString('http://example.asset.com', $link);
    }

    public function testMixUrl(): void
    {
        config()->set('app.mix_url', 'http://example.mix.com');

        $link = $this->getOrchidMixLink();

        $this->assertStringContainsString('http://example.mix.com', $link);
    }

    /**
     * @return string
     */
    protected function getOrchidMixLink(): string
    {
        return orchid_mix('/css/orchid.css', 'orchid');
    }
}
