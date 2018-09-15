<?php

declare(strict_types=1);

namespace Tests\Feature\Example;

use Orchid\Platform\Models\User;
use Orchid\Platform\Models\Role;
use Orchid\Tests\TestFeatureCase;

class RoleTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= RoleTest tests\\Feature\\Example\\RoleTest --debug
     * @var
     */
    private $user;
    
    private $role;
    
    public function setUp()
    {
        parent::setUp();
        
        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
        $this->role = factory(Role::class)->create();
    }

    public function test_route_SystemsRoles()
    {
        $response = $this->actingAs($this->user)
                    ->get(route('platform.systems.roles'));
        $response->assertStatus(200);
        $this->assertContains($this->role->name, $response->baseResponse->content());
        $this->assertContains($this->role->slug, $response->baseResponse->content());
    }  
    public function test_route_SystemsRolesCreate()
    {
        $response = $this->actingAs($this->user)
                    ->get(route('platform.systems.roles.create'));
        $response->assertStatus(200);
        $this->assertContains('field--roleslug', $response->baseResponse->content());
    }      
    public function test_route_SystemsRolesEdit()
    {
        $response = $this->actingAs($this->user)
                    ->get(route('platform.systems.roles.edit',$this->role->slug));
        $response->assertStatus(200);
        $this->assertContains('field--roleslug', $response->baseResponse->content());
        $this->assertContains($this->role->name, $response->baseResponse->content());
        $this->assertContains($this->role->slug, $response->baseResponse->content());
    }      


}
