<?php

declare(strict_types=1);

namespace Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class AnnouncementTest extends TestFeatureCase
{
    /**
     * @var User
     */
    private $user;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_open_screen()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.systems.announcement'));

        $response->assertStatus(200);
    }

    private function createAnnouncement($text = 'Global Announcement Test')
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('platform.systems.announcement', ['saveOrUpdate']), [
                'announcement' => [
                    'content' => $text,
                ],
            ]);

        $response->assertStatus(302);

        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.main'));

        $this->assertContains($text, $response->getContent());
    }

    public function test_rewrite_announcement()
    {
        $this->createAnnouncement();
        $this->createAnnouncement('Global Announcement Test Rewrite');
    }


    public function test_delete_announcement($text = 'Delete Announcement')
    {
        $this->createAnnouncement($text);

        $this
            ->actingAs($this->user)
            ->post(route('platform.systems.announcement', ['disabled']));

        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.main'));

        $this->assertNotContains($text, $response->getContent());
    }

}