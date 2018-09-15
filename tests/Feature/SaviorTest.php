<?php

declare(strict_types=1);

namespace Tests\Feature\Example;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class SaviorTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= SaviorTest tests\\Feature\\SaviorTest --debug.
     * @var
     */
    private $user;

    public function setUp()
    {
        parent::setUp();
        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
    }

    public function test_route_SaviorBackups()
    {
        $response = $this->actingAs($this->user)
                    ->get(route('platform.savior.backups'));
        $response->assertStatus(200);
    }

    public function test_route_SaviorBackups_method_runBackup()
    {
        $response = $this->actingAs($this->user)
                    ->post(route('platform.savior.backups', 'runBackup'));
        //dump($response);
        $response->assertStatus(302);
    }
}
