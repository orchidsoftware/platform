<?php

declare(strict_types=1);

namespace Tests\Feature\Example;

use Orchid\Tests\TestFeatureCase;

class ArtisanTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= ArtisanTest tests\\Feature\\ArtisanTest --debug.
     * @var
     */
    public function test_artisan_orchid_entity_many()
    {
        $this->artisan('orchid:entity-many', ['name' => studly_case(__FUNCTION__)])
            ->expectsOutput('Behavior created successfully.');
    }

    public function test_artisan_orchid_entity_single()
    {
        $this->artisan('orchid:entity-single', ['name' => studly_case(__FUNCTION__)])
            ->expectsOutput('Behavior created successfully.');
    }


    public function test_artisan_orchid_chart()
    {
        $this->artisan('orchid:chart', ['name' => studly_case(__FUNCTION__)])
            ->expectsOutput('Chart created successfully.');
    }


    public function test_artisan_orchid_table()
    {
        $this->artisan('orchid:table', ['name' => studly_case(__FUNCTION__)])
            ->expectsOutput('Table created successfully.');
    }

    public function test_artisan_orchid_widget()
    {
        $this->artisan('orchid:widget', ['name' => studly_case(__FUNCTION__)])
            ->expectsOutput('Widget created successfully.');
    }

    public function test_artisan_orchid_screen()
    {
        $this->artisan('orchid:screen', ['name' => studly_case(__FUNCTION__)])
            ->expectsOutput('Screen created successfully.');
    }

    public function test_artisan_orchid_rows()
    {
        $this->artisan('orchid:rows', ['name' => studly_case(__FUNCTION__)])
            ->expectsOutput('Rows created successfully.');
    }

    public function test_artisan_orchid_filter()
    {
        $this->artisan('orchid:filter', ['name' => studly_case(__FUNCTION__)])
            ->expectsOutput('Filter created successfully.');
    }
}
