<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class AnnouncementTest extends TestFeatureCase
{
    public function testOpenScreen()
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.systems.announcement'));

        $response->assertOk();
    }

    public function testRewriteAnnouncement()
    {
        $this->createAnnouncement();
        $this->createAnnouncement('Global Announcement Test Rewrite');
    }

    private function createAnnouncement($text = 'Global Announcement Test')
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.announcement', ['saveOrUpdate']), [
                'announcement' => [
                    'content' => $text,
                ],
            ]);

        $response->assertStatus(302);

        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.main'));

        $response->assertSee($text);
    }

    public function testDeleteAnnouncement($text = 'Delete Announcement')
    {
        $this->createAnnouncement($text);

        $this
            ->actingAs($this->createAdminUser())
            ->post(route('platform.systems.announcement', ['disabled']));

        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('platform.main'));

        $response->assertDontSee($text);
    }
}
