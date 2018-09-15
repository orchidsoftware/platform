<?php

declare(strict_types=1);

namespace Tests\Feature\Example;


use Orchid\Tests\TestFeatureCase;
use Illuminate\Support\Facades\Artisan;

class ArtisanTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= ArtisanTest tests\\Feature\\ArtisanTest --debug
     * @var
     */

    public function test_artisan_orchid_entity_many()
    {
        $response = $this->artisan('orchid:entity-many',['name' => 'DefaultName']);
        
        //$response = Artisan::call('orchid:entity-many', ['name' => 'DefaultName']);
        //$resultAsText = Artisan::output();
        
        //dump($response);
        $this->assertTrue(true);
    }
   
    public function test_artisan_orchid_entity_single()
    {
        $response = $this->artisan('orchid:entity-single',['name' => 'DefaultName']);

        $this->assertTrue(true);
    }
  
 /*
    public function test_artisan_orchid_chart()
    {
        $response = $this->artisan('orchid:chart',['name' => 'DefaultName']);

        $this->assertTrue(true);
    }
  */  
   
    public function test_artisan_orchid_table()
    {
        $response = $this->artisan('orchid:table',['name' => 'DefaultName']);
        //$response = Artisan::call('orchid:chart', ['name' => 'DefaultName']);
        //$resultAsText = Artisan::output();
        //dump($resultAsText);
        $this->assertTrue(true);
    }
    
    public function test_artisan_orchid_widget()
    {
        $response = $this->artisan('orchid:widget',['name' => 'DefaultName']);

        $this->assertTrue(true);
    }
 
 
    public function test_artisan_orchid_screen()
    {
        $response = $this->artisan('orchid:screen',['name' => 'DefaultName']);

        $this->assertTrue(true);
    }

    public function test_artisan_orchid_rows()
    {
        $response = $this->artisan('orchid:rows',['name' => 'DefaultName']);

        $this->assertTrue(true);
    }
        
    public function test_artisan_orchid_filter()
    {
        $response = $this->artisan('orchid:filter',['name' => 'DefaultName']);

        $this->assertTrue(true);
    }

}
