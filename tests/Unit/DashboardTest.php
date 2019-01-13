<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Tests\TestUnitCase;
use Orchid\Platform\Models\User;

/**
 * Class DashboardTest.
 */
class DashboardTest extends TestUnitCase
{
    public function testIsVersion()
    {
        $this->assertEquals(Dashboard::version(), Dashboard::VERSION);
    }

    public function testIsModelDefault()
    {
        $class = Dashboard::modelClass('UnknownClass', User::class);

        $default = new User();

        $this->assertEquals($class, $default);
    }

    public function testIsModelCustomNotFound()
    {
        Dashboard::useModel(User::class, 'MyCustomClass');

        $user = Dashboard::modelClass(User::class);

        $this->assertEquals($user, 'MyCustomClass');
    }

    public function testIsModelConfigure()
    {
        Dashboard::configure([
            'models' => [
                User::class => 'MyCustomClass',
            ],
        ]);

        $class = Dashboard::model(User::class);
        $option = Dashboard::option('models.'.User::class);

        $this->assertEquals($class, 'MyCustomClass');
        $this->assertEquals($option, 'MyCustomClass');
        $this->assertEquals(Dashboard::option('random'), null);
    }

    protected function setUp()
    {
        parent::setUp();
        Dashboard::configure([]);
    }

    protected function tearDown()
    {
        parent::tearDown();
        Dashboard::configure([]);
    }
}
